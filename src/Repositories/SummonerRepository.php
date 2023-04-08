<?php

namespace RiotApiConnector\Repositories;

use RiotApiConnector\Http\Requests\SummonerRequest;

class SummonerRepository extends Repository
{
    public function __construct(?string $regionName)
    {
        parent::__construct($regionName);
        $this->query = $this->query->where('region_id', $this->region?->id);
    }

    public function byId(string $id): SummonerRepository
    {
        $this->request = new SummonerRequest(
            endpoint: config('riot.endpoints.summoner.by_id'),
            urlParams: [
                'encryptedSummonerId' => $id,
            ],
            region: $this->region
        );

        $this->query = $this->query->where('summoner_id', $id);

        return $this;
    }

    public function byPuuid(string $puuid): SummonerRepository
    {
        $this->request = new SummonerRequest(
            endpoint: config('riot.endpoints.summoner.by_puuid'),
            urlParams: [
                'encryptedPUUID' => $puuid,
            ],
            region: $this->region
        );

        return $this;
    }

    public function byName(string $name): SummonerRepository
    {
        $this->request = new SummonerRequest(
            endpoint: config('riot.endpoints.summoner.by_name'),
            urlParams: [
                'summonerName' => $name,
            ],
            region: $this->region
        );

        return $this;
    }

    public function byAccountId(string $accountId): SummonerRepository
    {
        $this->request = new SummonerRequest(
            endpoint: config('riot.endpoints.summoner.by_account_id'),
            urlParams: [
                'encryptedAccountId' => $accountId,
            ],
            region: $this->region
        );

        return $this;
    }
}
