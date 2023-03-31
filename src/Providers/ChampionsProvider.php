<?php

namespace RiotApiConnector\Providers;

use RiotApiConnector\Contracts\DataDragonProvider;
use RiotApiConnector\Models\Champion;

class ChampionsProvider extends AbstractProvider implements DataDragonProvider
{
    protected function getUrl(): string
    {
        return config('data-dragon.data.champions');
    }

    protected function mapDataToModels(array $data)
    {
        if (empty($data)) {
            return;
        }

        Champion::truncate();

        $formattedData = [];
        foreach ($data as $rawData) {
            $formattedData[] = [
                'key' => $rawData['key'],
                'name' => $rawData['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Champion::unguard();
        Champion::insert($formattedData);
        Champion::reguard();
    }
}
