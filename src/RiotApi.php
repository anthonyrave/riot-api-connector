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
     * @param Region $region
     * @return SummonerRepository
     * @throws BindingResolutionException
     */
    public static function summoner(Region $region): SummonerRepository
    {
        return Summoner::repository($region);
    }

    /**
     * @param Summoner $summoner
     * @return MasteryRepository
     * @throws BindingResolutionException
     */
    public static function mastery(Summoner $summoner): MasteryRepository
    {
        return Mastery::repository($summoner);
    }
}
