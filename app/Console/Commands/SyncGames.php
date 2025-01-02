<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Services\SteamApiClient;
use Illuminate\Console\Command;
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

        while ($haveMoreResults) {
            $this->line('Téléchargement du paquet...');

            $response = $steamApiClient->getAppList($lastAppId, includeDlc: false, includeSoftware: false, includeVideos: false,
                includeHardware: false);

            $games = collect($response->apps ?? []);

            if ($games->isEmpty()) {
                $this->line('Paquet vide');

                break;
            }

            $haveMoreResults = $response->have_more_results ?? false;
            $lastAppId = $response->last_appid ?? null;

            $this->line('Mise à jour de la BDD..');

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

        $games = collect($csv->getRecords());

        $this->line('Mise à jour de la BDD..');

        Game::upsert(
            $games->map(fn (array $game, int $index): array => ['id' => -$index, 'name' => $game['name'], 'custom_url' => $game['url']])->all(),
            ['id'],
            ['name', 'custom_url']
        );

        // TODO Supprimer les anciens jeux

        $this->info('Effectué');

        return self::SUCCESS;
    }
}
