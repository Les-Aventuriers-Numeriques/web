<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameProposal;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create();
        $game = Game::factory()->create();

        $proposal = GameProposal::factory()
            ->for($user)
            ->for($game)
            ->create();

        $vote = Vote::factory()
            ->for($user)
            ->for($proposal, 'votable')
            ->create();
    }
}
