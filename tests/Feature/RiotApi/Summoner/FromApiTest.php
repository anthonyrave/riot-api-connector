<?php

use GuzzleHttp\UriTemplate\UriTemplate;
use RiotApiConnector\Facades\RiotApi;
use RiotApiConnector\Models\Summoner;

it('can be retrieved by ID from API', function () {
    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_id'), [
        'encryptedSummonerId' => $summoner->summoner_id,
    ]);

    fakeRiotApiResponse($region, $endpoint, $json);

    expect(RiotApi::summoner($region)->byId($summoner->summoner_id)->fromApi())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by name from API', function () {
    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_name'), [
        'summonerName' => $summoner->name,
    ]);

    fakeRiotApiResponse($region, $endpoint, $json);

    expect(RiotApi::summoner($region)->byName($summoner->name)->fromApi())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by account ID from API', function () {
    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_account_id'), [
        'encryptedAccountId' => $summoner->account_id,
    ]);

    fakeRiotApiResponse($region, $endpoint, $json);

    expect(RiotApi::summoner($region)->byAccountId($summoner->account_id)->fromApi())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by PUUID from API', function () {
    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_puuid'), [
        'encryptedPUUID' => $summoner->puuid,
    ]);

    fakeRiotApiResponse($region, $endpoint, $json);

    expect(RiotApi::summoner($region)->byPuuid($summoner->puuid)->fromApi())
        ->toBeInstanceOf(Summoner::class);
});
