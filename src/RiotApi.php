<?php

namespace RiotApiConnector;

use Illuminate\Contracts\Container\BindingResolutionException;
use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Models\Mastery;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Models\Summoner;
use RiotApiConnector\Repositories\MasteryRepository;
use RiotApiConnector\Repositories\SummonerRepository;

class RiotApi implements RiotApiFactory
{
    /**
     * @throws BindingResolutionException
     */
    public static function summoner(Region $region): SummonerRepository
    {
        return Summoner::repository($region);
    }

    /**
     * @throws BindingResolutionException
     */
    public static function mastery(Region $region, Summoner $summoner): MasteryRepository
    {
        return Mastery::repository($region, $summoner);
    }
}
