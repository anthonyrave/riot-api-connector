<?php

namespace RiotApiConnector\Contracts;

use RiotApiConnector\Repositories\SummonerRepository;

interface RiotApiFactory
{
    public function summoner(string $regionName): SummonerRepository;

    public function useCache(): bool;
}
