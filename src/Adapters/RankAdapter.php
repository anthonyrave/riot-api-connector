<?php

namespace RiotApiConnector\Adapters;

use Illuminate\Database\Eloquent\Collection;
use RiotApiConnector\Models\MiniSeries;
use RiotApiConnector\Models\Rank;
use RiotApiConnector\Models\Summoner;

class RankAdapter extends Adapter
{
    protected ?Summoner $summoner = null;

    public function newFromApi(array $data): Collection
    {
        if (!count($data) || !isset($data[0]['summonerId'])) {
            return new Collection();
        }

        if ($this->summoner === null) {
            $this->summoner = Summoner::whereEncryptedSummonerId($data[0]['summonerId'])->first();
        }

        $rankCollection = new Collection();
        foreach ($data as $datum) {
            $rankCollection->push($this->newRank($datum));
        }

        return $rankCollection;
    }

    protected function newRank(array $data): Rank
    {
        $params = [
            'league_id' => $data['leagueId'],
            'summoner_id' => $this->summoner->id,
            'queue_type' => $data['queueType'],
            'tier' => $data['tier'],
            'rank' => $data['rank'],
            'league_points' => $data['leaguePoints'],
            'wins' => $data['wins'],
            'losses' => $data['losses'],
            'hot_streak' => $data['hotStreak'],
            'veteran' => $data['veteran'],
            'fresh_blood' => $data['freshBlood'],
            'inactive' => $data['inactive'],
        ];

        if (config('riot_api_connector.cache.enabled')) {
            $rank = Rank::updateOrCreate(
                [
                    'summoner_id' => $this->summoner->id,
                    'queue_type' => $data['queueType'],
                ],
                $params
            );
        } else {
            $rank = new Rank($params);
        }

        if (isset($data['miniSeries'])) {
            $miniSeries = new MiniSeries([
                'losses' => $data['miniSeries']['losses'],
                'progress' => $data['miniSeries']['progress'],
                'target' => $data['miniSeries']['target'],
                'wins' => $data['miniSeries']['wins'],
            ]);
            $miniSeries->rank()->associate($rank);
        }

        return $rank;
    }
}
