<?php

namespace RiotApiConnector;

use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Factories\SummonerRequestFactory;

class RiotApi implements RiotApiFactory
{
    public function summoner(string $server): SummonerRequestFactory
    {
        return new SummonerRequestFactory(server: $server);
    }
}
