<?php

namespace App\Http\Controllers\Hub;

use App\Models\User;
use App\Services\DiscordApiClient;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Config;
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
        $displayName = AuthFacade::user()?->display_name;

        AuthFacade::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        flash()->success("À plus $displayName !");

        return to_hub_route('auth.login');
    }

    public function redirect(): RedirectResponse
    {
        /** @var Provider $driver */
        $driver = Socialite::driver('discord');

        return $driver
            ->scopes(Config::array('services.discord.scopes'))
            ->redirect();
    }

    public function callback(DiscordApiClient $discordApiClient): RedirectResponse
    {
        /** @var Provider $driver */
        $driver = Socialite::driver('discord');

        try {
            $discordUser = $driver->user();
        } catch (InvalidStateException $e) {
            report($e);

            flash()->danger('Erreur lors de la connexion avec Discord. Rééssaye de zéro STP.');

            return to_hub_route('auth.login');
        }

        $guildId = Config::integer('services.discord.guild_id');
        $user = User::findOrNew($discordUser->getId());
        $isNewUser = ! $user->exists;

        if ($isNewUser) {
            $user->id = (int) $discordUser->getId();
        }

        try {
            $membershipInfo = $discordApiClient
                ->withToken($discordUser->token)
                ->getGuildMembership($guildId);
        } catch (RequestException) {
            if (! $isNewUser) {
                $user
                    ->resetRoles()
                    ->save();
            }

            flash()->warning('Tu n\'est pas présent sur notre serveur Discord.');

            return to_hub_route('auth.login');
        }

        if (! $membershipInfo) {
            flash()->danger('Réponse de Discord invalide.');

            return to_hub_route('auth.login');
        }

        $user->updateFromDiscord($discordUser, $membershipInfo);

        $hasAnyRole = $user->is_member || $user->is_lan_participant || $user->is_admin;

        if ($isNewUser && ! $hasAnyRole) {
            flash()->warning('Tu n\'as pas l\'autorisation d\'accéder à notre intranet.');

            return to_hub_route('auth.login');
        }

        $user->save();

        if (! $hasAnyRole) {
            flash()->warning('Désolé, tu n\'as plus l\'autorisation d\'accéder à notre intranet.');

            return to_hub_route('auth.login');
        }

        AuthFacade::login($user, true);

        flash()->success(sprintf("%s $user->display_name !", $isNewUser ? 'Bienvenue' : 'Content de te revoir'));

        return to_hub_route('home');
    }
}
