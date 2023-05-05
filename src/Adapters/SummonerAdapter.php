<?php

namespace RiotApiConnector\Adapters;

use Illuminate\Support\Carbon;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Models\Summoner;

class SummonerAdapter extends Adapter
{
    public function __construct(
        protected readonly Region $region
    )
    {
    }

    public function newFromApi(array $data): Summoner
    {
        $attributes = [
            'region_id' => $this->region->id,
            'encrypted_summoner_id' => $data['id'],
            'encrypted_account_id' => $data['accountId'],
            'encrypted_puuid' => $data['puuid'],
            'summoner_name' => $data['name'],
            'profile_icon_id' => $data['profileIconId'],
            'revision_date' => Carbon::createFromTimestamp(substr($data['revisionDate'], 0, 10)),
            'summoner_level' => $data['summonerLevel'],
        ];

        if (config('riot_api_connector.cache.enabled')) {
            return Summoner::updateOrCreate(
                [
                    'region_id' => $this->region->id,
                    'summoner_name' => $data['name'],
                ],
                $attributes
            );
        }

        return new Summoner($attributes);
    }
}
