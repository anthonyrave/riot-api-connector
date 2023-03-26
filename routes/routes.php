<?php

use Anthonyrave\RiotApiConnector\Http\Controllers\SummonerController;
use Illuminate\Support\Facades\Route;

Route::prefix('/riot')->group(function () {
    Route::prefix('/summoners')->group(function () {
        Route::get('/{serverName}/{summonerName}', [SummonerController::class, 'show']);
    });
});
