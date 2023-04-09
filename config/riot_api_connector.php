<?php

return [

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
        'duration' => 10 * 24 * 60 * 60, // 10 days
        //        'duration' => 10, // for testing
    ],

];
