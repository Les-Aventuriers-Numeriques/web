<?php

namespace App\Http\Controllers\Hub;

use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use SocialiteProviders\Discord\Provider;

class Auth extends Controller
{
    public function login(): View
    {
        SEOMeta::setTitle('Connexion');

        return hub_view('login');
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = $request->user();
        $username = '';

        if ($user) {
            $username = $user->display_name;

            AuthFacade::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return to_hub_route('auth.login')
            ->withAlert("À plus $username !", 'success');
    }

    public function redirect(): RedirectResponse
    {
        /** @var Provider $driver */
        $driver = Socialite::driver('discord');

        return $driver
            ->scopes(Config::array('services.discord.scopes'))
            ->redirect();
    }

    public function callback(): RedirectResponse
    {
        /** @var Provider $driver */
        $driver = Socialite::driver('discord');

        try {
            $discordUser = $driver->user();
        } catch (InvalidStateException $e) {
            return to_hub_route('auth.login')
                ->withAlert("Erreur lors de la connexion avec Discord ({$e->getMessage()}). Rééssaye de zéro STP.", 'error');
        }

        $guildId = Config::integer('services.discord.guild_id');
        $user = User::find($discordUser->getId());
        $isNewUser = ! $user instanceof User;

        $membershipInfoResponse = Http::baseUrl('https://discord.com/api')
            ->acceptJson()
            ->asJson()
            ->withToken($discordUser->token)
            ->get("/users/@me/guilds/$guildId/member");

        if (! $membershipInfoResponse->ok()) {
            if (! $isNewUser) {
                $user
                    ->resetRoles()
                    ->save();
            }

            return to_hub_route('auth.login')
                ->withAlert('Tu n\'est pas présent sur notre serveur Discord.', 'warning');
        }

        $membershipInfo = $membershipInfoResponse->object();

        if (! $membershipInfo) {
            return to_hub_route('auth.login')
                ->withAlert('Réponse invalide.', 'error');
        }

        $roles = User::determineRoles($membershipInfo);

        if ($isNewUser) {
            if (! data_get($roles, 'hasAnyRole', false)) {
                return to_hub_route('auth.login')
                    ->withAlert('Tu n\'as pas l\'autorisation d\'accéder à notre intranet.', 'warning');
            }

            $user = User::makeFromDiscord($discordUser);
        }

        $user
            ->updateFromDiscord($discordUser, $membershipInfo, $roles)
            ->save();

        if (! data_get($roles, 'hasAnyRole', false)) {
            return to_hub_route('auth.login')
                ->withAlert('Désolé, tu n\'as plus l\'autorisation d\'accéder à notre intranet.', 'warning');
        }

        AuthFacade::login($user, true);

        return to_hub_route('home')
            ->withAlert(sprintf("%s $user->display_name !", $isNewUser ? 'Bienvenue' : 'Content de te revoir'), 'success');
    }
}
