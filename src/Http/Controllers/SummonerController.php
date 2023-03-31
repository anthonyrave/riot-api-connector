<?php

namespace RiotApiConnector\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use RiotApiConnector\Http\RiotApi;

class SummonerController extends Controller
{
    /**
     * @throws GuzzleException
     */
    public function show(string $serverName, string $summonerName): JsonResponse
    {
        $response = RiotApi::get(
            '/lol/summoner/v4/summoners/by-name/'.$summonerName,
            $serverName
        );

        return response()->json($response);
    }
}
