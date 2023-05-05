<?php

namespace RiotApiConnector\Contracts;

use RiotApiConnector\Models\Summoner;
use RiotApiConnector\Repositories\Repository;

interface RiotApiFactory
{
    public static function summoner(): Repository;

    public static function mastery(Summoner $summoner): Repository;
}
