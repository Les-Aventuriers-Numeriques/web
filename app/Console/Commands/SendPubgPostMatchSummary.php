<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendPubgPostMatchSummary extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:send-pubg-post-match-summary';

    /**
     * @var string
     */
    protected $description = 'Sends messages on our Discord server about our played PUBG matches';

    public function handle(): int
    {
        return self::SUCCESS;
    }
}
