<?php

namespace RiotApiConnector\Repositories;

use RiotApiConnector\Http\Requests\PendingRequest;

class SummonerRepository extends Repository
{
    public function __construct(?string $regionName = null)
    {
        parent::__construct($regionName);

        $this->query->where('region_id', $this->region?->id);
    }

    public function byId(string $id): SummonerRepository
    {
        $this->request = new PendingRequest(
            endpoint: config('riot.endpoints.summoner.by_id'),
            urlParams: [
                'encryptedSummonerId' => $id,
            ],
            region: $this->region
        );

        $this->query->where('summoner_id', $id);

        return $this;
    }

    public function byPuuid(string $puuid): SummonerRepository
    {
        $this->request = new PendingRequest(
            endpoint: config('riot.endpoints.summoner.by_puuid'),
            urlParams: [
                'encryptedPUUID' => $puuid,
            ],
            region: $this->region
        );

        $this->query->where('puuid', $puuid);

        return $this;
    }

    public function byName(string $name): SummonerRepository
    {
        $this->request = new PendingRequest(
            endpoint: config('riot.endpoints.summoner.by_name'),
            urlParams: [
                'summonerName' => $name,
            ],
            region: $this->region
        );

        $this->query->where('name', $name);

        return $this;
    }

    public function byAccountId(string $accountId): SummonerRepository
    {
        $this->request = new PendingRequest(
            endpoint: config('riot.endpoints.summoner.by_account_id'),
            urlParams: [
                'encryptedAccountId' => $accountId,
            ],
            region: $this->region
        );

        $this->query->where('account_id', $accountId);

        return $this;
    }
}
