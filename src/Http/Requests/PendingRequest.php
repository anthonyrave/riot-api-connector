<?php

namespace RiotApiConnector\Http\Requests;

use Illuminate\Support\Facades\Http;
use RiotApiConnector\Models\Region;

// TODO Handle Request exceptions and add hints (API Token...)
class PendingRequest
{
    public string $endpoint;

    public array $url_params;

    public ?Region $region;

    public function __construct(
    ) {
    }

    public function fetch()
    {
        $response = Http::withHeaders(
            ['X-Riot-Token' => config('riot.token')]
        )
            ->baseUrl($this->getBaseUrl())
            ->withUrlParameters($this->url_params)
            ->get($this->endpoint);

        return $response->json();
    }

    private function getBaseUrl(): string
    {
        return ($this->region ? 'https://'.$this->region->name.'.' : 'https://').config('riot.url');
    }
}
