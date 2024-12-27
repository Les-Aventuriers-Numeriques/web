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

    public function getGuildMembership(int $guildId): object
    {
        return $this->call("users/@me/guilds/$guildId/member");
    }

    private function call(string $resource): object
    {
        if (! $this->token) {
            throw new InvalidArgumentException('Discord API client requires a token to be set');
        }

        $response = Http::baseUrl('https://discord.com/api')
            ->asJson()
            ->acceptJson()
            ->withToken($this->token)
            ->get($resource)
            ->throw()
            ->object();

        return is_array($response)
            ? collect($response)
            : $response;
    }
}
