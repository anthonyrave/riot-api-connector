<?php

namespace RiotApiConnector\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use RiotApiConnector\Facades\RiotApi;

class ChampionMasteryController extends Controller
{
    public function showTop(string $serverName, string $summonerId, int $count = null): JsonResponse
    {
        $response = RiotApi::get(
            '/lol/champion-mastery/v4/champion-masteries/by-summoner/{summoner}/top{?count}',
            [
                'server' => $serverName,
                'summoner' => $summonerId,
                'count' => $count,
            ]
        );

        return response()->json($response);
    }
}
