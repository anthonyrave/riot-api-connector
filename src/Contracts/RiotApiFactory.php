<?php

namespace RiotApiConnector\Contracts;

use RiotApiConnector\Http\Requests\SummonerRequest;

interface RiotApiFactory
{
    public function summoner(string $server): SummonerRequest;
}
