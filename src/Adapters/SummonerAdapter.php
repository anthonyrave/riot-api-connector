<?php

namespace RiotApiConnector\Adapters;

use Illuminate\Support\Carbon;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Models\Summoner;

class SummonerAdapter
{
    public static function newFromApi(array $data, Region $region): Summoner
    {
        $params = [
            'region_id' => $region->id,
            'summoner_id' => $data['id'],
            'account_id' => $data['accountId'],
            'puuid' => $data['puuid'],
            'name' => $data['name'],
            'profile_icon_id' => $data['profileIconId'],
            'revision_date' => Carbon::createFromTimestamp(substr($data['revisionDate'], 0, 10)),
            'summoner_level' => $data['summonerLevel'],
        ];

        if (config('riot_api_connector.cache.enabled')) {
            return Summoner::updateOrCreate(
                [
                    'region_id' => $region->id,
                    'name' => $data['name'],
                ],
                $params
            );
        }

        return new Summoner($params);
    }
}
