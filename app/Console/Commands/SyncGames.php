<?php

namespace App\Console\Commands;

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
    protected $description = 'Syncs games from Steam to the DB';

    public function handle(): int
    {
        return self::SUCCESS;
    }
}
