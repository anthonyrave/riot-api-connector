<?php

namespace RiotApiConnector\Contracts;

use RiotApiConnector\Factories\SummonerRequestFactory;

interface RiotApiFactory
{
    public function summoner(string $server): SummonerRequestFactory;
}
