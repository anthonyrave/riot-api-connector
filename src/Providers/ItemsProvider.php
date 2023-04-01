<?php

namespace RiotApiConnector\Providers;

use RiotApiConnector\Contracts\DataDragonProvider;

class ItemsProvider extends AbstractProvider implements DataDragonProvider
{
    protected function getUrl(): string
    {
        return config('data-dragon.data.items');
    }

    protected function mapDataToModels(array $data)
    {
        // TODO: Implement mapDataToModel() method.
    }

    protected function getUrlParameters(): array
    {
        // TODO: Implement getUrlParameters() method.
    }
}
