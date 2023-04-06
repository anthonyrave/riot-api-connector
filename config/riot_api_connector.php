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

    'token' => env('RIOT_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Url
    |--------------------------------------------------------------------------
    |
    | Riot Games API base url
    |
    */

    'url' => 'api.riotgames.com',

    /*
    |--------------------------------------------------------------------------
    | Servers
    |--------------------------------------------------------------------------
    |
    | Riot servers list (required for some requests)
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Endpoints
    |--------------------------------------------------------------------------
    |
    | Riot API endpoints
    |
    */

    'endpoints' => [
        'summoner' => [
            'by_id' => '/lol/summoner/v4/summoners/{encryptedSummonerId}',
            'by_puuid' => '/lol/summoner/v4/summoners/by-puuid/{encryptedPUUID}',
            'by_name' => '/lol/summoner/v4/summoners/by-name/{summonerName}',
            'by_account_id' => '/lol/summoner/v4/summoners/by-account/{encryptedAccountId}',
        ],
    ],

];
