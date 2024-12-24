<?php

namespace App\Pubg;

use Illuminate\Support\Facades\Http;

class ApiClient
{
    public function __construct(private string $token)
    {
    }

    public function getPlayers()
    {

    }

    public function getMatch()
    {

    }

    private function call(string $resource): object
    {
        return Http::baseUrl('https://api.pubg.com/')
            ->asJson()
            ->accept('application/vnd.api+json')
            ->withToken($this->token)
            ->throw()
            ->get($resource)
            ->object();
    }
}
