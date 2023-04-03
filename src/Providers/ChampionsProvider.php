<?php

namespace RiotApiConnector\Providers;

use RiotApiConnector\Contracts\DataDragonProvider;
use RiotApiConnector\Models\Champion\Champion;
use RiotApiConnector\Models\Tag;

class ChampionsProvider extends AbstractProvider implements DataDragonProvider
{
    protected function getUrl(): string
    {
        return config('data-dragon.data.champions');
    }

    protected function mapDataToModels(array $data)
    {
        $lg = $this->getLocale();
        foreach ($data as $championData) {
            $champion = Champion::updateOrCreate(
                [
                    'key' => $championData['key'],
                    'riot_id' => $championData['id'],
                ],
                [
                    'name' => [$lg => $championData['name']],
                    'title' => [$lg => $championData['title']],
                    'blurb' => [$lg => $championData['blurb']],
                    'partype' => [$lg => $championData['partype']],
                ]
            );

            $champion->image()->firstOrCreate($championData['image']);
            $champion->info()->firstOrCreate($championData['info']);
            $champion->stats()->firstOrCreate($championData['stats']);

            foreach ($championData['tags'] as $tagName) {
                Tag::firstOrCreate(['name' => $tagName])->champions()->attach($champion);
            }
        }
    }
}
