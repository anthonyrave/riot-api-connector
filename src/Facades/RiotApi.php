<?php

namespace RiotApiConnector\Facades;

use Illuminate\Support\Facades\Facade;
use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Models\Summoner;
use RiotApiConnector\Repositories\Repository;

/**
 * @method Repository summoner()
 * @method Repository mastery(Summoner $summoner)
 */
class RiotApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RiotApiFactory::class;
    }
}
