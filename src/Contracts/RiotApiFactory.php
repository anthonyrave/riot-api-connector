<?php

namespace RiotApiConnector\Contracts;

use RiotApiConnector\Models\Region;
use RiotApiConnector\Models\Summoner;
use RiotApiConnector\Repositories\MasteryRepository;
use RiotApiConnector\Repositories\SummonerRepository;

interface RiotApiFactory
{
    public static function summoner(Region $region): SummonerRepository;

    public static function mastery(Region $region, Summoner $summoner): MasteryRepository;
}
