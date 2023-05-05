<?php

namespace RiotApiConnector;

use Illuminate\Contracts\Container\BindingResolutionException;
use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Models\Mastery;
use RiotApiConnector\Models\Summoner;
use RiotApiConnector\Repositories\Repository;

class RiotApi implements RiotApiFactory
{
    /**
     * @return Repository
     * @throws BindingResolutionException
     */
    public static function summoner(): Repository
    {
        return Summoner::repository();
    }

    /**
     * @param Summoner $summoner
     * @return Repository
     * @throws BindingResolutionException
     */
    public static function mastery(Summoner $summoner): Repository
    {
        return Mastery::repository(['summoner' => $summoner]);
    }
}
