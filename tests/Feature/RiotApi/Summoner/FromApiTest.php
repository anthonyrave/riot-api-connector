<?php

use GuzzleHttp\UriTemplate\UriTemplate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RiotApiConnector\Adapters\SummonerAdapter;
use RiotApiConnector\Facades\RiotApi;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Models\Summoner;

it('can be retrieved by ID from API', function () {
    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_id'), [
        'encryptedSummonerId' => $summoner->summoner_id
    ]);

    fakeResponse($region, $endpoint, $json);

    expect(RiotApi::summoner($region)->byId($summoner->summoner_id)->fromApi())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by name from API', function () {
    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_name'), [
        'summonerName' => $summoner->name
    ]);

    fakeResponse($region, $endpoint, $json);

    expect(RiotApi::summoner($region)->byName($summoner->name)->fromApi())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by account ID from API', function () {
    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_account_id'), [
        'encryptedAccountId' => $summoner->account_id
    ]);

    fakeResponse($region, $endpoint, $json);

    expect(RiotApi::summoner($region)->byAccountId($summoner->account_id)->fromApi())
        ->toBeInstanceOf(Summoner::class);
});

it('can be retrieved by PUUID from API', function () {
    [$region, $summoner, $json] = initFakeSummonerFetch();

    $endpoint = UriTemplate::expand(config('riot.endpoints.summoner.by_puuid'), [
        'encryptedPUUID' => $summoner->puuid
    ]);

    fakeResponse($region, $endpoint, $json);

    expect(RiotApi::summoner($region)->byPuuid($summoner->puuid)->fromApi())
        ->toBeInstanceOf(Summoner::class);
});

function initFakeSummonerFetch(): array
{
    /** @var Region $region */
    $region = Region::query()->where('name', 'euw1')->first();

    $json = File::get(__DIR__ . '/../../../Datasets/summoner.json');
    $summonerArray = json_decode($json, true);
    $summoner = SummonerAdapter::newFromApi($summonerArray, $region->id);

    return [$region, $summoner, $json];
}

function fakeResponse(Region $region, string $endpoint, string $json): void
{
    $fullUrl = $region->name . '.' . config('riot.url') . $endpoint;

    Http::fake([
        $fullUrl => Http::response($json),
    ]);
}