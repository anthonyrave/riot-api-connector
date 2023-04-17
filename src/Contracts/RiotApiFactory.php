<?php

namespace RiotApiConnector\Contracts;

use RiotApiConnector\Models\Region;
use RiotApiConnector\Repositories\SummonerRepository;

interface RiotApiFactory
{
    public static function summoner(Region $region): SummonerRepository;
}
