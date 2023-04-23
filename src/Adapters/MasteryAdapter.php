<?php

namespace RiotApiConnector\Adapters;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use RiotApiConnector\Models\Champion\Champion;
use RiotApiConnector\Models\Mastery;
use RiotApiConnector\Models\Summoner;

class MasteryAdapter
{
    public static function newFromApi(array $data, ?Summoner $summoner = null, ?Champion $champion = null): Mastery|Collection
    {
        if (Arr::isAssoc($data)) {
            return static::newMastery($data, $summoner, $champion);
        }

        return self::newMasteryCollection($data, $summoner);
    }

    protected static function newMasteryCollection(array $data, Summoner $summoner): Collection
    {
        $masteryCollection = new Collection();
        foreach ($data as $datum) {
            $masteryCollection->push(static::newMastery($datum, $summoner));
        }

        return $masteryCollection;
    }

    protected static function newMastery(array $data, Summoner $summoner, ?Champion $champion = null): Mastery
    {
        if ($champion === null) {
            $champion = Champion::query()->where('key', $data['championId'])->first();
        }

        $params = [
            'champion_id' => $champion->id,
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
                    'champion_id' => $champion->id,
                    'summoner_id' => $summoner->id,
                ],
                $params
            );
        }

        return new Mastery($params);
    }
}
