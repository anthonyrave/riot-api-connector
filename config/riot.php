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
    | URL
    |--------------------------------------------------------------------------
    |
    | Riot Games API base url
    |
    */

    'url' => 'api.riotgames.com',

    /*
    |--------------------------------------------------------------------------
    | Regions
    |--------------------------------------------------------------------------
    |
    | Riot regions list (required for some requests)
    |
    */

    'regions' => [
        'br1',
        'eun1',
        'euw1',
        'jp1',
        'kr',
        'la1',
        'la2',
        'na1',
        'oc1',
        'ph2',
        'ru',
        'sg2',
        'th2',
        'tr1',
        'tw2',
        'vn2',
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
        'match' => [
            'by_id' => '/lol/match/v5/matches/{matchId}',
            'by_puuid' => '/lol/match/v5/matches/by-puuid/{puuid}/ids',
            'timeline' => '/lol/match/v5/matches/{matchId}/timeline',
        ],
        'mastery' => [
            'default' => '/lol/champion-mastery/v4/champion-masteries/by-summoner/{encryptedSummonerId}',
            'top' => '/lol/champion-mastery/v4/champion-masteries/by-summoner/{encryptedSummonerId}/top',
            'by_champion' => '/lol/champion-mastery/v4/champion-masteries/by-summoner/{encryptedSummonerId}/by-champion/{championId}',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Champion masteries
    |--------------------------------------------------------------------------
    |
    | Points required for any level and cumulated
    |
    */

    'masteries' => [
        0 => [
            'required' => 0,
            'cumulated' => 0,
            'tokens' => 0,
        ],
        1 => [
            'required' => 1800,
            'cumulated' => 1800,
            'tokens' => 0,
        ],
        2 => [
            'required' => 4200,
            'cumulated' => 6000,
            'tokens' => 0,
        ],
        3 => [
            'required' => 6600,
            'cumulated' => 12600,
            'tokens' => 0,
        ],
        4 => [
            'required' => 9000,
            'cumulated' => 21600,
            'tokens' => 0,
        ],
        5 => [
            'required' => 0,
            'cumulated' => 0,
            'tokens' => 2,
        ],
        6 => [
            'required' => 0,
            'cumulated' => 0,
            'tokens' => 3,
        ],
        7 => [
            'required' => 0,
            'cumulated' => 0,
            'tokens' => 0,
        ],
    ],

];
