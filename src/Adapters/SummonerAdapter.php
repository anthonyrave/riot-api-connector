<?php

namespace RiotApiConnector\Adapters;

use RiotApiConnector\Models\Summoner;

class SummonerAdapter
{
    public static function newFromApi(array $data, ?int $regionId = null): Summoner
    {
        return new Summoner([
            'region_id' => $regionId,
            'summoner_id' => $data['id'],
            'account_id' => $data['accountId'],
            'puuid' => $data['puuid'],
            'name' => $data['name'],
            'profile_icon_id' => $data['profileIconId'],
            'revision_date' => date('Y-m-d H:i:s', substr($data['revisionDate'], 0, 10)),
            'summoner_level' => $data['summonerLevel'],
        ]);
    }
}
