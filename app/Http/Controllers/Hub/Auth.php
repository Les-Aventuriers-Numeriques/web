<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth as AuthService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth as AuthFacade;

class Auth extends Controller
{
    public function __construct(private AuthService $auth) {}

    public function login(): View
    {
        return view('hub.login');
    }

    public function redirect(): RedirectResponse
    {
        return $this->auth->redirect();
    }

    public function callback(): RedirectResponse
    {
        $discordUser = $this->auth->user();
        $user = User::find($discordUser->getId());
        $isNewUser = ! $user instanceof User;

        $membershipInfoResponse = $this->auth->membershipInfo($discordUser);

        if (! $membershipInfoResponse->ok()) {
            if ($user) {
                // TODO Suppression de tous les rôles
            }

            return to_route('web.hub.auth.login')
                ->with('warning', sprintf('Tu n\'est %s présent sur notre serveur Discord.', $user ? 'plus' : 'pas'));
        }

        $membershipInfo = $membershipInfoResponse->object();

        $roles = data_get($membershipInfo, 'roles', []);

        $isMember = in_array(config('services.discord.member_role_id'), $roles);
        $isLanParticipant = in_array(config('services.discord.member_role_id'), $roles);
        $isAdmin = in_array(config('services.discord.member_role_id'), $roles);
        $hasAnyRole = $isMember || $isLanParticipant || $isAdmin;

        if ($isNewUser) {
            if (! $hasAnyRole) {
                return to_route('web.hub.auth.login')
                    ->with('warning', 'Tu n\'as pas l\'autorisation d\'accéder à notre intranet.');
            }

            $user = new User;
            $user->id = $discordUser->getId();
        }

        $userInfo = data_get($membershipInfo, 'user');

        $user->display_name = data_get($membershipInfo, 'nick')
            ?? data_get($userInfo, 'global_name')
            ?? data_get($userInfo, 'username');

        $memberAvatarHash = data_get($membershipInfo, 'avatar');
        $userAvatarHash = data_get($userInfo, 'avatar');

        if ($memberAvatarHash) {
            $guildId = config('services.discord.guild_id');

            $user->avatar_url = "https://cdn.discordapp.com/guilds/$guildId/users/{$discordUser->getId()}/avatars/$memberAvatarHash.png";
        } elseif ($userAvatarHash) {
            $user->avatar_url = "https://cdn.discordapp.com/avatars/{$discordUser->getId()}/$userAvatarHash.png";
        }

        $user->save();

        // TODO MàJ des rôles

        if (! $hasAnyRole) {
            return to_route('web.hub.auth.login')
                ->with('warning', 'Désolé, tu n\'as plus l\'autorisation d\'accéder à notre intranet.');
        }

        AuthFacade::login($user);

        return to_route('web.hub.home')
            ->with('success', sprintf("%s $user->display_name !", $isNewUser ? 'Bienvenue' : 'Content de te revoir'));
    }
}
