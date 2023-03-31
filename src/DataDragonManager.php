<?php

namespace RiotApiConnector;

use Illuminate\Support\Manager;
use RiotApiConnector\Contracts\DataDragonFactory;
use RiotApiConnector\Providers\ChampionsProvider;
use RiotApiConnector\Providers\ItemsProvider;

class DataDragonManager extends Manager implements DataDragonFactory
{
    protected function createChampionsDriver()
    {
        return $this->buildProvider(ChampionsProvider::class);
    }

    protected function createItemsDriver()
    {
        return $this->buildProvider(ItemsProvider::class);
    }

    private function buildProvider(string $provider)
    {
        return new $provider();
    }

    public function getDefaultDriver()
    {
        // Do it for every driver ?
    }
}
