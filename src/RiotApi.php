<?php

namespace RiotApiConnector;

use Illuminate\Contracts\Container\BindingResolutionException;
use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Models\Summoner;

class RiotApi implements RiotApiFactory
{
    /**
     * @throws BindingResolutionException
     */
    public static function summoner(Region $region): Repositories\SummonerRepository
    {
        return Summoner::repository($region);
    }
}
