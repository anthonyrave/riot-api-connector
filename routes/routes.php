<?php

use Illuminate\Support\Facades\Route;
use RiotApiConnector\Http\Controllers\ChampionMasteryController;
use RiotApiConnector\Http\Controllers\SummonerController;
use RiotApiConnector\Http\Resources\ChampionResource;
use RiotApiConnector\Models\Champion;

Route::prefix('/{serverName}')->group(function () {
    Route::get('/summoners/{summonerName}', [SummonerController::class, 'show']);
    Route::get('/champion-masteries/{summonerId}/top/{count?}', [ChampionMasteryController::class, 'showTop']);
});

Route::get('/champions', fn () => ChampionResource::collection(Champion::all()));
