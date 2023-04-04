<?php

namespace RiotApiConnector\Facades;

use Illuminate\Support\Facades\Facade;
use RiotApiConnector\Contracts\SummonerFactory;

class Summoner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SummonerFactory::class;
    }
}
