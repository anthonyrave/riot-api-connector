<?php

namespace RiotApiConnector;

use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Repositories\SummonerRepository;

class RiotApi implements RiotApiFactory
{
    public function summoner(string $regionName): SummonerRepository
    {
        return new SummonerRepository(regionName: $regionName);
    }
}
