<?php

namespace RiotApiConnector\Facades;

use Illuminate\Support\Facades\Facade;
use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Repositories\SummonerRepository;

/**
 * @method SummonerRepository summoner(Region $region)
 * @method bool useCache()
 */
class RiotApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RiotApiFactory::class;
    }
}
