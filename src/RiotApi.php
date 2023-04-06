<?php

namespace RiotApiConnector;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Http\Requests\SummonerRequest;

class RiotApi implements RiotApiFactory
{
    protected string $server;

    public function __construct(
        private readonly string $baseUri,
        private readonly string $token
    ) {
    }

    public function summoner(string $server): SummonerRequest
    {
        $this->server = $server;

        return new SummonerRequest($server);
    }

    public function get(string $url, array $params = [], bool $requiresServer = true): array
    {
        $response = $this->prepareRequest($params, $requiresServer)->get($url);

        return $response->json();
    }

    private function prepareRequest(array $params = [], bool $requiresServer = true): PendingRequest
    {
        $baseUri = ($requiresServer ? 'https://{server}.' : 'https://').$this->baseUri;

        return Http::withHeaders([
            'X-Riot-Token' => $this->token,
        ])->baseUrl($baseUri)->withUrlParameters($params);
    }
}
