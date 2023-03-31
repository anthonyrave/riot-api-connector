<?php

use Illuminate\Support\Facades\Route;
use RiotApiConnector\Http\Controllers\ChampionController;
use RiotApiConnector\Http\Controllers\ChampionMasteryController;
use RiotApiConnector\Http\Controllers\SummonerController;

Route::prefix('/{serverName}')->group(function () {
    Route::prefix('/summoners')->group(function () {
        Route::get('/{summonerName}', [SummonerController::class, 'show']);
    });
    Route::prefix('/champion-masteries')->group(function () {
        Route::prefix('/{summonerId}')->group(function () {
            Route::get('/top/{count?}', [ChampionMasteryController::class, 'showTop']);
        });
    });
});

Route::prefix('/champions')->group(function () {
    Route::get('/', [ChampionController::class, 'index']);
});
