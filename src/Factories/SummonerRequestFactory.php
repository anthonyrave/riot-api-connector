<?php

namespace RiotApiConnector\Factories;

use RiotApiConnector\Http\Requests\SummonerRequest;

class SummonerRequestFactory extends RequestFactory
{
    public function byId(string $id): SummonerRequest
    {
        return $this->request(
            endpoint: config('riot_api_connector.endpoints.summoner.by_id'),
            urlParams: [
                'encryptedSummonerId' => $id,
            ]
        );
    }

    public function byPuuid(string $puuid): SummonerRequest
    {
        return $this->request(
            endpoint: config('riot_api_connector.endpoints.summoner.by_puuid'),
            urlParams: [
                'encryptedPUUID' => $puuid,
            ]
        );
    }

    public function byName(string $name): SummonerRequest
    {
        return $this->request(
            endpoint: config('riot_api_connector.endpoints.summoner.by_name'),
            urlParams: [
                'summonerName' => $name,
            ]
        );
    }

    public function byAccountId(string $accountId): SummonerRequest
    {
        return $this->request(
            endpoint: config('riot_api_connector.endpoints.summoner.by_account_id'),
            urlParams: [
                'encryptedAccountId' => $accountId,
            ]
        );
    }
}
