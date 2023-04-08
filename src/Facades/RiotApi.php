<?php

namespace RiotApiConnector\Facades;

use Illuminate\Support\Facades\Facade;
use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Repositories\SummonerRepository;

/**
 * @method SummonerRepository summoner(string $regionName)
 */
class RiotApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RiotApiFactory::class;
    }
}
