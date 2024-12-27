<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SteamApiClient
{
    public function __construct(private string $key) {}

    public function getAppList(
        ?int $lastAppId = null, ?int $maxResults = 2000, bool $includeGames = true, bool $includeDlc = true,
        bool $includeSoftware = true, bool $includeVideos = true, bool $includeHardware = true
    ): ?object {
        return $this->call(
            'IStoreService/GetAppList/v1/',
            [
                'last_appid' => $lastAppId,
                'max_results' => $maxResults,
                'include_games' => $includeGames,
                'include_dlc' => $includeDlc,
                'include_software' => $includeSoftware,
                'include_videos' => $includeVideos,
                'include_hardware' => $includeHardware,
            ]
        )->response;
    }

    /**
     * @param array<array-key, mixed> $params
     */
    private function call(string $resource, array $params = []): ?object
    {
        return Http::baseUrl('https://api.steampowered.com')
            ->asJson()
            ->acceptJson()
            ->withQueryParameters(array_merge(
                [
                    'key' => $this->key,
                ],
                $params
            ))
            ->get($resource)
            ->throw()
            ->object();
    }
}
