<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RiotApiConnector\Models\Rank;

class RankFactory extends Factory
{
    protected $model = Rank::class;

    public function definition(): array
    {
        return [
            'league_id' => fake()->text(20),
        ];
    }
}
