<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RiotApiConnector\Models\Summoner;

class SummonerFactory extends Factory
{
    protected $model = Summoner::class;

    public function definition(): array
    {
        return [
            'summonerId' => $this->faker->randomAscii(),
            'accountId' => $this->faker->randomAscii(),
            'puuid' => $this->faker->randomAscii(),
            'name' => $this->faker->userName(),
            'profileIconId' => $this->faker->randomNumber(3),
            'revisionDate' => $this->faker->dateTime(),
            'summonerLevel' => $this->faker->randomNumber(4),
        ];
    }
}
