<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class DiscordApiClient
{
    private string $token;

    public function withToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getGuildMembership(int $guildId): ?object
    {
        return $this->call("users/@me/guilds/$guildId/member");
    }

    private function call(string $resource, string $method = 'get'): ?object
    {
        if (! $this->token) {
            throw new InvalidArgumentException('Discord API client requires an access token to be set');
        }

        return Http::baseUrl('https://discord.com/api')
            ->asJson()
            ->acceptJson()
            ->withToken($this->token)
            ->send($method, $resource)
            ->throw()
            ->object();
    }
}
