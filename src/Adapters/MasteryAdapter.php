<?php

namespace RiotApiConnector\Adapters;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use RiotApiConnector\Models\Mastery;
use RiotApiConnector\Models\Summoner;

class MasteryAdapter
{
    public static function newFromApi(array $data, Summoner $summoner): Mastery|Collection
    {
        // TODO Check if $data is a list of masteries or a mastery

        $params = [
            'champion_id' => $data['championId'],
            'summoner_id' => $summoner->id,
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
                    'champion_id' => $data['championId'],
                    'summoner_id' => $summoner->id,
                ],
                $params
            );
        }

        return new Mastery($params);
    }
}
