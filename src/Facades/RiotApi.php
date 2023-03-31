<?php

namespace RiotApiConnector\Facades;

use Illuminate\Support\Facades\Facade;
use RiotApiConnector\Contracts\RiotApiFactory;

/**
 * @method static Array get(string $url, array $params = [], bool $requiresServer = true)
 */
class RiotApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RiotApiFactory::class;
    }
}
