<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SteamApiClient
{
    public function __construct(private string $key) {}

    public function getAppList(
        ?int $lastAppId = null, ?int $maxResults = 3000, bool $includeGames = true, bool $includeDlc = true,
        bool $includeSoftware = true, bool $includeVideos = true, bool $includeHardware = true
    ): ?object {
        return $this->call(
            'IStoreService',
            'GetAppList',
            [
                'last_appid' => $lastAppId,
                'max_results' => $maxResults,
                'include_games' => $includeGames ? 'true' : 'false',
                'include_dlc' => $includeDlc ? 'true' : 'false',
                'include_software' => $includeSoftware ? 'true' : 'false',
                'include_videos' => $includeVideos ? 'true' : 'false',
                'include_hardware' => $includeHardware ? 'true' : 'false',
            ]
        )?->response;
    }

    /**
     * @param  array<array-key, mixed>  $params
     */
    private function call(string $service, string $method, array $params = [], int $version = 1, string $httpMethod = 'get'): ?object
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
            ->send($httpMethod, "$service/$method/v$version")
            ->throw()
            ->object();
    }
}
