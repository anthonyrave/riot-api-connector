<?php

use RiotApiConnector\Facades\RiotApi;
use RiotApiConnector\Models\Summoner;

it('can be retrieved by ID from DB', function () {
    [$region, $summoner] = initFakeSummonerFetch();

    expect(RiotApi::summoner($region)->byId($summoner)->FromDb())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by name from DB', function () {
    [$region, $summoner] = initFakeSummonerFetch();

    expect(RiotApi::summoner($region)->byName($summoner)->FromDb())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by account ID from DB', function () {
    [$region, $summoner] = initFakeSummonerFetch();

    expect(RiotApi::summoner($region)->byAccountId($summoner)->FromDb())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by PUUID from DB', function () {
    [$region, $summoner] = initFakeSummonerFetch();

    expect(RiotApi::summoner($region)->byPuuid($summoner)->FromDb())
        ->toBeInstanceOf(Summoner::class);
});
