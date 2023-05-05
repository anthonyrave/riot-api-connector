<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Region settings
    |--------------------------------------------------------------------------
    |
    | Region default configuration for API requests.
    |
    */

    'region' => 'euw1',

    /*
    |--------------------------------------------------------------------------
    | Cache settings
    |--------------------------------------------------------------------------
    |
    | In order to reduce API requests, Riot API connector comes with a "cache"
    | feature. It enabled, it will save into your database API responses as
    | Models.
    |
    */

    'cache' => [
        'enabled' => true,
        'duration' => 7 * 24 * 60 * 60, // 7 days
        //        'duration' => 10, // 10s for testing
    ],

];
