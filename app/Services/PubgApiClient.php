<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class PubgApiClient
{
    public function __construct(private string $token) {}

    /**
     * @param  list<string>  $playersName
     * @param  list<string>  $playersId
     */
    public function getPlayers(string $shard, array $playersName = [], array $playersId = []): ?object
    {
        if ((! $playersName && ! $playersId) || ($playersName && $playersId)) {
            throw new InvalidArgumentException('Either $playersName or $playersId must be provided');
        }

        $filterName = sprintf('filter[%s]', $playersName ? 'playerNames' : 'playerIds');
        $filterValue = implode(',', $playersName ?: $playersId);

        return $this->call(
            "shards/$shard/players",
            [
                $filterName => $filterValue,
            ]
        );
    }

    public function getMatch(string $shard, string $matchId): ?object
    {
        return $this->call(
            "shards/$shard/matches/$matchId",
            needsAuth: false
        );
    }

    /**
     * @param array<array-key, mixed> $params
     */
    private function call(string $resource, array $params = [], bool $needsAuth = true): ?object
    {
        return Http::baseUrl('https://api.pubg.com/')
            ->asJson()
            ->accept('application/vnd.api+json')
            ->withHeader('Accept-Encoding', 'gzip')
            ->withQueryParameters($params)
            ->when($needsAuth, function (PendingRequest $request) use ($resource) {
                if (! $this->token) {
                    throw new InvalidArgumentException("$resource requires authentication but no JWT token has been set");
                }

                $request->withToken($this->token);
            })
            ->get($resource)
            ->throw()
            ->object();
    }
}
