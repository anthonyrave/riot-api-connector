<?php

use GuzzleHttp\UriTemplate\UriTemplate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use function Pest\Laravel\artisan;
use RiotApiConnector\Models\Champion\Champion;

it('tell the user if a given data type is unknown', function () {
    artisan('riot-api-connector:fetch --data=unknown')
        ->expectsOutput('Data of type "unknown" does not exist.');
});

it('can fetch champions from DataDragon', function () {
    $championsUrl = UriTemplate::expand(config('data_dragon.data.champions'), [
        'version' => '13.7.1',
        'lang' => config('data_dragon.default.lang'),
    ]);

    Http::fake([
        config('data_dragon.data.versions') => Http::response(['13.7.1', '13.6.1']),
        $championsUrl => Http::response(File::get(__DIR__.'/../Datasets/correct-champions.json')),
    ]);

    artisan('riot-api-connector:fetch --data=champions')
        ->expectsOutput('Retrieving latest version...')
        ->expectsOutput('13.7.1')
        ->expectsOutput('Done');

    expect(Champion::all())->toHaveCount(2);
});
