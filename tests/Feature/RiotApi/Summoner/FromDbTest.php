<?php

use RiotApiConnector\Facades\RiotApi;
use RiotApiConnector\Models\Summoner;

it('can be retrieved by ID from DB', function () {
    [$region, $summoner] = initFakeSummonerFetch();

    expect(RiotApi::summoner($region)->byId($summoner->summoner_id)->FromDb())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by name from DB', function () {
    [$region, $summoner] = initFakeSummonerFetch();

    expect(RiotApi::summoner($region)->byName($summoner->name)->FromDb())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by account ID from DB', function () {
    [$region, $summoner] = initFakeSummonerFetch();

    expect(RiotApi::summoner($region)->byAccountId($summoner->account_id)->FromDb())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by PUUID from DB', function () {
    [$region, $summoner] = initFakeSummonerFetch();

    expect(RiotApi::summoner($region)->byPuuid($summoner->puuid)->FromDb())
        ->toBeInstanceOf(Summoner::class);
});