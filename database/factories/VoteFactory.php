<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Overtrue\LaravelVote\Vote;

/**
 * @extends Factory<Vote>
 */
class VoteFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'votes' => fake()->numberBetween(-3, 10),
        ];
    }
}
