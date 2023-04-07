<?php

namespace RiotApiConnector\Http\Requests;

use Illuminate\Support\Facades\Http;

abstract class PendingRequest
{
    public function __construct(
        protected readonly string $endpoint,
        protected array $urlParams = [],
        protected ?string $server = null,
    ) {
    }

    public function get()
    {
        $response = Http::withHeaders(
            ['X-Riot-Token' => config('riot_api_connector.token')]
        )
            ->baseUrl($this->getBaseUrl())
            ->withUrlParameters($this->urlParams)
            ->get($this->endpoint);

        return $response->json();
    }

    private function getBaseUrl(): string
    {
        return ($this->server ? 'https://'.$this->server.'.' : 'https://').config('riot_api_connector.url');
    }
}
