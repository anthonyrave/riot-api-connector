<?php

namespace RiotApiConnector\Services;

use RiotApiConnector\Contracts\SummonerFactory;
use RiotApiConnector\RiotApiService;

class SummonerService implements SummonerFactory
{
    public function __construct(
        private readonly RiotApiService $riotApiService
    ) {
    }

    public function byId(string $id)
    {
        $this->riotApiService
            ->get('/lol/summoner/v4/summoners/{id}');
    }

    public function byPuuid(string $puuid)
    {
        $this->riotApiService->get('/lol/summoner/v4/summoners/by-puuid/{puuid}');
    }

    public function byName(string $name)
    {
        // TODO: Implement byName() method.
    }

    public function byAccount(string $accountId)
    {
        // TODO: Implement byAccount() method.
    }
}
