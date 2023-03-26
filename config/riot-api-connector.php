<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | API Key get this on https://developer.riotgames.com/
    |
    */

    'api_key' => env('RIOT_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Domain
    |--------------------------------------------------------------------------
    |
    | In case you want to use a subdomain. Learn more on
    | https://laravel.com/docs/10.x/routing#route-group-subdomain-routing
    |
    */

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Prefix
    |--------------------------------------------------------------------------
    |
    | Learn more on https://laravel.com/docs/10.x/routing#route-group-prefixes
    |
    */

    'prefix' => 'riot',

    /*
    |--------------------------------------------------------------------------
    | Base URI
    |--------------------------------------------------------------------------
    |
    | Riot API base URI
    |
    */

    'base_uri' => 'api.riotgames.com',

    /*
    |--------------------------------------------------------------------------
    | LoL API information
    |--------------------------------------------------------------------------
    |
    | LoL API information
    |
    */

    'lol' => [
        'prefix' => '/lol',
        'routes' => [
            'summoner' => [
                'prefix' => '/summoner/v4/summoners',
            ],
            'champion_mastery' => [
                'prefix' => '/champion-mastery/v4/champion-masteries',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Servers
    |--------------------------------------------------------------------------
    |
    | Riot servers list (required for some requests)
    |
    */

    // TODO : Better use an Enum ?
    'servers' => [
        'BR1',
        'EUN1',
        'EUW1',
        'JP1',
        'KR',
        'LA1',
        'LA2',
        'NA1',
        'OC1',
        'PH2',
        'RU',
        'SG2',
        'TH2',
        'TR1',
        'TW2',
        'VN2',
    ],

];
