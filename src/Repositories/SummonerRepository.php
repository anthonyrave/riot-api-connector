<?php

namespace RiotApiConnector\Repositories;

use RiotApiConnector\Models\Summoner;

class SummonerRepository extends Repository
{
    protected string $model = Summoner::class;

    public function byId(string $id): SummonerRepository
    {
        $this->request->endpoint = config('riot.endpoints.summoner.by_id');
        $this->request->url_params = [
            'encryptedSummonerId' => $id,
        ];

        $this->query->where('summoner_id', $id);

        return $this;
    }

    public function byPuuid(string $puuid): SummonerRepository
    {
        $this->request->endpoint = config('riot.endpoints.summoner.by_puuid');
        $this->request->url_params = [
            'encryptedPUUID' => $puuid,
        ];

        $this->query->where('puuid', $puuid);

        return $this;
    }

    public function byName(string $name): SummonerRepository
    {
        $this->request->endpoint = config('riot.endpoints.summoner.by_name');
        $this->request->url_params = [
            'summonerName' => $name,
        ];

        $this->query->where('name', $name);

        return $this;
    }

    public function byAccountId(string $accountId): SummonerRepository
    {
        $this->request->endpoint = config('riot.endpoints.summoner.by_account_id');
        $this->request->url_params = [
            'encryptedAccountId' => $accountId,
        ];

        $this->query->where('account_id', $accountId);

        return $this;
    }
}
