<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RiotApiConnector\Models\Region;

class RegionFactory extends Factory
{
    protected $model = Region::class;

    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(config('riot.regions')),
        ];
    }
}
