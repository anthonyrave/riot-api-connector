<?php

namespace RiotApiConnector\Providers;

use RiotApiConnector\Contracts\DataDragonProvider;
use RiotApiConnector\Models\Champion\Champion;
use RiotApiConnector\Models\Champion\ChampionTag;

class ChampionsProvider extends AbstractProvider implements DataDragonProvider
{
    protected function getUrl(): string
    {
        return config('data_dragon.data.champions');
    }

    protected function mapDataToModels(array $data)
    {
        $lang = $this->getLocale();
        foreach ($data as $championData) {
            $champion = Champion::updateOrCreate(
                [
                    'key' => $championData['key'],
                    'riot_id' => $championData['id'],
                ],
                [
                    'name' => [$lang => $championData['name']],
                    'title' => [$lang => $championData['title']],
                    'blurb' => [$lang => $championData['blurb']],
                    'partype' => [$lang => $championData['partype']],
                ]
            );

            $champion->image()->firstOrCreate($championData['image']);
            $champion->info()->firstOrCreate($championData['info']);
            $champion->stats()->firstOrCreate($championData['stats']);

            foreach ($championData['tags'] as $tagName) {
                ChampionTag::firstOrCreate(['name' => $tagName])->champions()->attach($champion);
            }
        }
    }
}
