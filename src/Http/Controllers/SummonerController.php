<?php

namespace RiotApiConnector\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use RiotApiConnector\Facades\RiotApi;

class SummonerController extends Controller
{
    public function show(string $serverName, string $summonerName): JsonResponse
    {
        $response = RiotApi::get(
            url: '/lol/summoner/v4/summoners/by-name/{summoner}',
            params: [
                'server' => $serverName,
                'summoner' => $summonerName,
            ]
        );

        return response()->json($response);
    }
}
