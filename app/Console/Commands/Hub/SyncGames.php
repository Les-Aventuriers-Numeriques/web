<?php

namespace App\Console\Commands\Hub;

use App\Models\Game;
use App\Services\SteamApiClient;
use Illuminate\Support\Collection;
use League\Csv\Reader;

class SyncGames extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:sync-games';

    /**
     * @var string
     */
    protected $description = 'Sync games from Steam';

    public function handle(SteamApiClient $steamApiClient): int
    {
        $this->line('Mise à jour des jeux Steam...');

        $haveMoreResults = true;
        $lastAppId = null;

        /** @var Collection<int, int> $allAppIds */
        $allAppIds = collect();

        while ($haveMoreResults) {
            $this->line('Téléchargement du paquet...');

            $response = $steamApiClient->getAppList($lastAppId, includeDlc: false, includeSoftware: false, includeVideos: false,
                includeHardware: false);

            /** @var Collection<int, object{appid: int, name: string}> $games */
            $games = collect($response->apps ?? []);

            if ($games->isEmpty()) {
                $this->line('Paquet vide');

                break;
            }

            $haveMoreResults = $response->have_more_results ?? false;
            $lastAppId = $response->last_appid ?? null;

            $this->line('Mise à jour de la BDD..');

            $allAppIds = $allAppIds->merge($games->pluck('appid'));

            Game::upsert(
                $games->map(fn (object $game): array => ['id' => $game->appid, 'name' => $game->name])->all(),
                ['id'],
                ['name']
            );
        }

        $this->line('Mise à jour des jeux personnalisés...');

        $csv = Reader::createFromPath(resource_path('data/games.csv'));
        $csv->setDelimiter(',');
        $csv->setHeaderOffset(0);

        /** @var Collection<int, array{name: string, url: string}> $games */
        $games = collect($csv->getRecords());

        Game::upsert(
            $games->map(function (array $game, int $index) use ($allAppIds): array {
                $id = -$index;

                $allAppIds->add($id);

                return ['id' => $id, 'name' => $game['name'], 'custom_url' => $game['url']];
            })->all(),
            ['id'],
            ['name', 'custom_url']
        );

        $this->line('Suppression des anciens jeux...');

        // Game::whereNotIn('id', $allAppIds)->delete(); FIXME

        $this->info('Effectué');

        return self::SUCCESS;
    }
}
