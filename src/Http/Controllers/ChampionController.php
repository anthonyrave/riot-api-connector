<?php

namespace RiotApiConnector\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class ChampionController extends Controller
{
    /**
     * TODO Server data stored in database instead
     */
    public function index(): JsonResponse
    {
        $data = json_decode(Http::get(config('data-dragon.champions')), true);

        return response()->json($data);
    }
}
