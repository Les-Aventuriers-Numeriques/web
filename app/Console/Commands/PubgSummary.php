<?php

namespace App\Console\Commands;

use App\Services\PubgApiClient;
use Illuminate\Console\Command;

class PubgSummary extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:pubg-summary';

    /**
     * @var string
     */
    protected $description = 'Send PUBG post-match summaries on our Discord server';

    public function handle(PubgApiClient $pubgApiClient): int
    {
        return self::SUCCESS;
    }
}
