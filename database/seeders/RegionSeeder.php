<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use RiotApiConnector\Models\Region;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = config('riot.regions');

        Region::factory()
            ->count(count($regions))
            ->sequence(fn (Sequence $sequence) => ['name' => $regions[$sequence->index]])
            ->create();
    }
}
