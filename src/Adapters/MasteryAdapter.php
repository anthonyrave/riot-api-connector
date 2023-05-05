<?php

namespace RiotApiConnector\Adapters;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use RiotApiConnector\Models\Champion\Champion;
use RiotApiConnector\Models\Mastery;
use RiotApiConnector\Models\Summoner;

class MasteryAdapter extends Adapter
{
    protected ?Champion $champion;
    protected ?Summoner $summoner = null;

    public function newFromApi(array $data): Mastery|Collection
    {
        if (isset($data['championId'])) {
            return $this->newMastery($data);
        }
        return $this->newMasteryCollection($data);
    }

    protected function newMastery(array $data): Mastery
    {
        $this->champion = Champion::query()->where('key', $data['championId'])->first();

        if ($this->summoner === null) {
            $this->summoner = Summoner::query()->whereEncryptedSummonerId($data['summonerId'])->first();
        }

        $params = [
            'champion_id' => $this->champion->id,
            'summoner_id' => $this->summoner->id,
            'champion_level' => $data['championLevel'],
            'champion_points' => $data['championPoints'],
            'last_play_time' => Carbon::createFromTimestamp(substr($data['lastPlayTime'], 0, 10)),
            'champion_points_since_last_level' => $data['championPointsSinceLastLevel'],
            'champion_points_until_next_level' => $data['championPointsUntilNextLevel'],
            'chest_granted' => $data['chestGranted'],
            'tokens_earned' => $data['tokensEarned'],
        ];

        if (config('riot_api_connector.cache.enabled')) {
            return Mastery::updateOrCreate(
                [
                    'champion_id' => $this->champion->id,
                    'summoner_id' => $this->summoner->id,
                ],
                $params
            );
        }

        return new Mastery($params);
    }

    protected function newMasteryCollection(array $data): Collection
    {
        $masteryCollection = new Collection();
        foreach ($data as $datum) {
            $masteryCollection->push($this->newMastery($datum));
        }

        return $masteryCollection;
    }
}
