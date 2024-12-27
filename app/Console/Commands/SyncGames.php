<?php

namespace App\Console\Commands;

use App\Services\SteamApiClient;
use Illuminate\Console\Command;

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
        return self::SUCCESS;
    }
}
