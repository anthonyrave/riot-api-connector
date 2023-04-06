<?php

namespace RiotApiConnector;

use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Http\Requests\SummonerRequest;

class RiotApi implements RiotApiFactory
{
    public function summoner(string $server): SummonerRequest
    {
        return new SummonerRequest(server: $server);
    }
}
