<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameProposal;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create();
        $games = Game::factory(5)->create();

        foreach ($games as $game) {
            GameProposal::factory()
                ->for($game)
                ->for($user)
                ->create();
        }
    }
}
