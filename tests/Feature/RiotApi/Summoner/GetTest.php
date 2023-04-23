<?php

use GuzzleHttp\UriTemplate\UriTemplate;
use RiotApiConnector\Facades\RiotApi;
use RiotApiConnector\Models\Summoner;

it('uses API if "cache" is disabled', function () {
    app()->disableRiotApiConnectorCache();

    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_id'), [
        'encryptedSummonerId' => $summoner->summoner_id,
    ]);

    $summoner->update([
        'name' => 'from DB',
    ]);

    fakeRiotApiResponse($region, $endpoint, $json);

    /** @var Summoner $summonerModel */
    $summonerModel = RiotApi::summoner($region)->byId($summoner->summoner_id)->get();
    expect($summonerModel)->toBeInstanceOf(Summoner::class)
        ->and($summonerModel->name)->toBe('from API');
});

it('uses API if "cache" is enabled but nothing found in DB', function () {
    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_id'), [
        'encryptedSummonerId' => $summoner->summoner_id,
    ]);

    $summoner->delete();

    fakeRiotApiResponse($region, $endpoint, $json);

    /** @var Summoner $summonerModel */
    $summonerModel = RiotApi::summoner($region)->byId($summoner->summoner_id)->get();
    expect($summonerModel)->toBeInstanceOf(Summoner::class)
        ->and($summonerModel->name)->toBe('from API');
});

it('uses DB if "cache" is enabled and data from DB is recent', function () {
    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_id'), [
        'encryptedSummonerId' => $summoner->summoner_id,
    ]);

    $summoner->update([
        'name' => 'from DB',
    ]);

    fakeRiotApiResponse($region, $endpoint, $json);

    /** @var Summoner $summonerModel */
    $summonerModel = RiotApi::summoner($region)->byId($summoner->summoner_id)->get();
    expect($summonerModel)->toBeInstanceOf(Summoner::class)
        ->and($summonerModel->name)->toBe('from DB');
});
