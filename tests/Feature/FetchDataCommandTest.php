<?php

use GuzzleHttp\UriTemplate\UriTemplate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use function Pest\Laravel\artisan;

it('can fetch data from DataDragon', function () {
    $championsUrl = UriTemplate::expand(config('data_dragon.data.champions'), [
        'version' => '13.7.1',
        'lang' => config('data_dragon.default.lang'),
    ]);

    Http::fake([
        config('data_dragon.data.versions') => Http::response(['13.7.1', '13.6.1']),
        $championsUrl => Http::response(File::get(__DIR__.'/../Datasets/champions.json')),
    ]);

    artisan('riot-api-connector:fetch')
        ->expectsOutput('Retrieving latest version...')
        ->expectsOutput('13.7.1');
});
