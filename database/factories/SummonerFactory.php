<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Models\Summoner;

class SummonerFactory extends Factory
{
    protected $model = Summoner::class;

    public function definition(): array
    {
        return [
            'region_id' => Region::factory(),
            'summoner_id' => fake()->randomAscii(),
            'account_id' => fake()->randomAscii(),
            'puuid' => fake()->randomAscii(),
            'name' => fake()->userName(),
            'profile_icon_id' => fake()->randomNumber(3),
            'revision_date' => fake()->dateTime(),
            'summoner_level' => fake()->randomNumber(4),
        ];
    }
}
