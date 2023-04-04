<?php

namespace RiotApiConnector\Services;

use RiotApiConnector\Contracts\SummonerFactory;
use RiotApiConnector\RiotApiService;

class SummonerService implements SummonerFactory
{
    protected string $server;

    public function __construct(
        private readonly RiotApiService $riotApiService,
    ) {
    }

    public function server(string $server): SummonerService
    {
        $this->server = $server;

        return $this;
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

    public function byName(string $name): array
    {
        return $this->riotApiService->get('/lol/summoner/v4/summoners/by-name/{name}', [
            'server' => 'euw1',
            'name' => $name,
        ]);
    }

    public function byAccount(string $accountId)
    {
        // TODO: Implement byAccount() method.
    }
}
