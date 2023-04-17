<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RiotApiConnector\Adapters\SummonerAdapter;
use RiotApiConnector\Models\Region;

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function initFakeSummonerFetch(): array
{
    /** @var Region $region */
    $region = Region::query()->where('name', 'euw1')->first();

    $json = File::get(__DIR__ . '/Datasets/summoner.json');
    $summonerArray = json_decode($json, true);
    $summoner = SummonerAdapter::newFromApi($summonerArray, $region->id);

    return [$region, $summoner, $json];
}

function fakeRiotApiResponse(Region $region, string $endpoint, string $json): void
{
    $fullUrl = $region->name . '.' . config('riot.url') . $endpoint;

    Http::fake([
        $fullUrl => Http::response($json),
    ]);
}