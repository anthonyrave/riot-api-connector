<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default parameters
    |--------------------------------------------------------------------------
    |
    | Default values to use to retrieve data
    |
    */

    'default' => [
        'lang' => 'en_US',
        'version' => '13.6.1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Data Dragon Data
    |--------------------------------------------------------------------------
    |
    | List of URLs to retrieve data of the different elements
    |
    */

    'data' => [
        'champions' => 'https://ddragon.leagueoflegends.com/cdn/{version}/data/{lang}/champion.json',
        'champion' => 'https://ddragon.leagueoflegends.com/cdn/{version}/data/{lang}/champion/{champion}.json',
        'items' => 'https://ddragon.leagueoflegends.com/cdn/{version}/data/{lang}/item.json',
        'languages' => 'https://ddragon.leagueoflegends.com/cdn/languages.json',
        'versions' => 'https://ddragon.leagueoflegends.com/api/versions.json',
        'realms' => 'https://ddragon.leagueoflegends.com/realms/{region}.json',
    ],

    /*
    |--------------------------------------------------------------------------
    | Data Dragon Images
    |--------------------------------------------------------------------------
    |
    | List of URLS where you can find images
    |
    */

    'images' => [
        'summonerIcon' => 'https://ddragon.leagueoflegends.com/cdn/13.6.1/img/profileicon/{id}.png',
    ],

];
