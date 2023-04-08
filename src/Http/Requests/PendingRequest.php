<?php

namespace RiotApiConnector\Http\Requests;

use Illuminate\Support\Facades\Http;
use RiotApiConnector\Models\Region;

abstract class PendingRequest
{
    public function __construct(
        protected readonly string $endpoint,
        protected array $urlParams = [],
        protected ?Region $region = null,
    ) {
    }

    public function get()
    {
        $response = Http::withHeaders(
            ['X-Riot-Token' => config('riot.token')]
        )
            ->baseUrl($this->getBaseUrl())
            ->withUrlParameters($this->urlParams)
            ->get($this->endpoint);

        return $response->json();
    }

    private function getBaseUrl(): string
    {
        return ($this->region ? 'https://'.$this->region->name.'.' : 'https://').config('riot.url');
    }
}
