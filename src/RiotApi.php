<?php

namespace RiotApiConnector;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RiotApiConnector\Contracts\RiotApiFactory;

class RiotApi implements RiotApiFactory
{
    protected string $server;

    public function __construct(
        private readonly string $baseUri,
        private readonly string $token
    ) {
    }

    public function summoner(string $server)
    {
        $this->server = $server;

        return new SummonerRequest();
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
