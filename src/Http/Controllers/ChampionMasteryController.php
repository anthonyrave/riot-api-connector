<?php

namespace RiotApiConnector\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use RiotApiConnector\Http\RiotApi;

class ChampionMasteryController extends Controller
{
    /**
     * @throws GuzzleException
     */
    public function showTop(string $serverName, string $summonerId, int $count = 3): JsonResponse
    {
        $response = RiotApi::get(
            '/lol/champion-mastery/v4/champion-masteries/by-summoner/'.$summonerId.'/top',
            $serverName,
            [
                'query' => [
                    'count' => $count,
                ],
            ]
        );

        return response()->json($response);
    }
}
