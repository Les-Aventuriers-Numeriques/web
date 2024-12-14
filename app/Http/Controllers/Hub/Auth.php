<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Discord\Provider;

class Auth extends Controller
{
    public function login(): View
    {
        return view('hub.login');
    }

    public function logout(Request $request): RedirectResponse
    {
        $username = AuthFacade::user()?->display_name;

        AuthFacade::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('web.hub.auth.login')
            ->with('success', "À plus $username !");
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

        $discordUser = $driver->user();
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

            return to_route('web.hub.auth.login')
                ->with('warning', 'Tu n\'est pas présent sur notre serveur Discord.');
        }

        $membershipInfo = $membershipInfoResponse->object();

        if (! $membershipInfo) {
            return to_route('web.hub.auth.login')
                ->with('error', 'Réponse invalide.');
        }

        $roles = User::determineRoles($membershipInfo);

        if ($isNewUser) {
            if (! data_get($roles, 'hasAnyRole', false)) {
                return to_route('web.hub.auth.login')
                    ->with('warning', 'Tu n\'as pas l\'autorisation d\'accéder à notre intranet.');
            }

            $user = new User;
            $user->id = (int) $discordUser->getId();
        }

        $user
            ->syncWithDiscord($discordUser, $membershipInfo, $roles)
            ->save();

        if (! data_get($roles, 'hasAnyRole', false)) {
            return to_route('web.hub.auth.login')
                ->with('warning', 'Désolé, tu n\'as plus l\'autorisation d\'accéder à notre intranet.');
        }

        AuthFacade::login($user);

        return to_route('web.hub.home')
            ->with('success', sprintf("%s $user->display_name !", $isNewUser ? 'Bienvenue' : 'Content de te revoir'));
    }
}
