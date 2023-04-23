<?php

use RiotApiConnector\Facades\RiotApi;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Models\Summoner;
use RiotApiConnector\Repositories\MasteryRepository;
use RiotApiConnector\Repositories\SummonerRepository;

it('may create a summoner repository', function () {
    $summonerRepository = RiotApi::summoner(Region::factory()->make());

    expect($summonerRepository)->toBeInstanceOf(SummonerRepository::class);
});

it('may create a mastery repository', function () {
    /** @var Region $region */
    $region = Region::query()->first();
    $masteryRepository = RiotApi::mastery(Summoner::factory()->recycle($region)->make());

    expect($masteryRepository)->toBeInstanceOf(MasteryRepository::class);
});