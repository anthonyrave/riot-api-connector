<?php

namespace RiotApiConnector\Facades;

use Illuminate\Support\Facades\Facade;
use RiotApiConnector\Contracts\RiotApiFactory;

/**
 * @method summoner(string $server)
 */
class RiotApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RiotApiFactory::class;
    }
}
