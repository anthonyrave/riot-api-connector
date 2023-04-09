<?php

namespace RiotApiConnector;

use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Repositories\SummonerRepository;

class RiotApi implements RiotApiFactory
{
    public function __construct(protected readonly bool $useCache)
    {
    }

    public function summoner(string $regionName): SummonerRepository
    {
        return new SummonerRepository(regionName: $regionName);
    }

    public function useCache(): bool
    {
        return $this->useCache;
    }
}
