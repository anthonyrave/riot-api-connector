<?php

namespace RiotApiConnector\Facades;

use Illuminate\Support\Facades\Facade;
use RiotApiConnector\Contracts\DataDragonFactory;
use RiotApiConnector\Contracts\DataDragonProvider;

/**
 * @method static DataDragonProvider driver(string $dataType = null)
 */
class DataDragon extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DataDragonFactory::class;
    }
}
