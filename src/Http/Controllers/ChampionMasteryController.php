<?php

namespace RiotApiConnector\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use RiotApiConnector\Facades\RiotApi;
use RiotApiConnector\Models\Champion;

class ChampionMasteryController extends Controller
{
    public function showTop(string $serverName, string $summonerId, int $count = null): JsonResponse
    {
        $masteries = RiotApi::get(
            '/lol/champion-mastery/v4/champion-masteries/by-summoner/{summoner}/top{?count}',
            [
                'server' => $serverName,
                'summoner' => $summonerId,
                'count' => $count,
            ]
        );

        $formattedData = [];
        foreach ($masteries as $mastery) {
            $formattedData[] = [
                'name' => Champion::where('key', $mastery['championId'])->firstOrFail()->name,
                'level' => $mastery['championLevel'],
                'points' => $mastery['championPoints'],
            ];
        }

        return response()->json($formattedData);
    }
}
