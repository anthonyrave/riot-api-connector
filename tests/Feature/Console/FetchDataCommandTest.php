<?php

use GuzzleHttp\UriTemplate\UriTemplate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use function Pest\Laravel\artisan;
use RiotApiConnector\Models\Champion\Champion;

it('stops if a given data type is invalid', function () {
    artisan('riot-api-connector:fetch --data=unknown --data=champions')
        ->expectsOutput('Data of type "unknown" does not exist.');
});

it('can fetch champions only', function () {
    fakeDataDragonChampionFetch();

    artisan('riot-api-connector:fetch --data=champions')
        ->expectsOutput('Retrieving latest version...')
        ->expectsOutput('13.7.1')
        ->expectsOutput('Data to fetch:')
        ->expectsOutput('- champions')
        ->expectsOutput('Done');

    expect(Champion::all())->toHaveCount(2);
});

it('can fetch all data types', function () {
    fakeDataDragonChampionFetch();

    artisan('riot-api-connector:fetch')
        ->expectsOutput('Retrieving latest version...')
        ->expectsOutput('13.7.1')
        ->expectsOutput('Fetch all data types')
        ->expectsOutput('Done');
});

function fakeDataDragonChampionFetch(): void
{
    $championsUrl = UriTemplate::expand(config('data_dragon.data.champions'), [
        'version' => '13.7.1',
        'lang' => config('data_dragon.default.lang'),
    ]);

    Http::fake([
        config('data_dragon.data.versions') => Http::response(['13.7.1', '13.6.1']),
        $championsUrl => Http::response(File::get(__DIR__.'/../../Fixtures/champions.json')),
    ]);
}
