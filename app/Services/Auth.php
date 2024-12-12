<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;

class Auth
{
    public function redirect(): RedirectResponse
    {
        return $this
            ->socialite()
            ->scopes(config('services.discord.scopes'))
            ->redirect();
    }

    public function discordUser(): User
    {
        return $this
            ->socialite()
            ->user();
    }

    public function membershipInfo(User $discordUser): Response
    {
        $guildId = config('services.discord.guild_id');

        return Http::acceptJson()
            ->asJson()
            ->withToken($discordUser->token)
            ->get("https://discord.com/api/users/@me/guilds/$guildId/member");
    }

    private function socialite(): Provider
    {
        return Socialite::driver('discord');
    }
}
