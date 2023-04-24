<?php

namespace RiotApiConnector\Http\Requests;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RiotApiConnector\Exceptions\InvalidApiKeyException;
use RiotApiConnector\Models\Region;

// TODO Handle Request exceptions and add hints (API Token...)
class PendingRequest
{
    public string $endpoint;

    public array $url_params;

    public ?Region $region;

    /**
     * @throws InvalidApiKeyException
     * @throws RequestException
     */
    public function fetch()
    {
        $response = Http::withHeaders(
            ['X-Riot-Token' => config('riot.token')]
        )
            ->baseUrl($this->getBaseUrl())
            ->withUrlParameters($this->url_params)
            ->get($this->endpoint);

        try {
            return $response->throw()->json();
        } catch (RequestException $e) {
            if ($response->status() === 403) {
                throw new InvalidApiKeyException('Your API Key is invalid. Please check if it has expired.', 403);
            }
            throw $e;
        }
    }

    private function getBaseUrl(): string
    {
        return ($this->region ? 'https://' . $this->region->name . '.' : 'https://') . config('riot.url');
    }
}
