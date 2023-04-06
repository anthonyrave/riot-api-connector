<?php

namespace RiotApiConnector\Http\Requests;

class SummonerRequest extends AbstractRequest
{
    public function byId(string $id): PendingRequest
    {
        return $this->withServer(
            endpoint: config('riot_api_connector.endpoints.summoner.by_id'),
            urlParams: [
                'encryptedSummonerId' => $id,
            ]
        );
    }

    public function byPuuid(string $puuid): PendingRequest
    {
        return $this->withServer(
            endpoint: config('riot_api_connector.endpoints.summoner.by_puuid'),
            urlParams: [
                'encryptedPUUID' => $puuid,
            ]
        );
    }

    public function byName(string $name): PendingRequest
    {
        return $this->withServer(
            endpoint: config('riot_api_connector.endpoints.summoner.by_name'),
            urlParams: [
                'summonerName' => $name,
            ]
        );
    }

    public function byAccountId(string $accountId): PendingRequest
    {
        return $this->withServer(
            endpoint: config('riot_api_connector.endpoints.summoner.by_account_id'),
            urlParams: [
                'encryptedAccountId' => $accountId,
            ]
        );
    }
}
