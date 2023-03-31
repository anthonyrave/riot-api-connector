<?php

namespace RiotApiConnector\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

// TODO remove everything (this is crap)
// No need to use guzzle use HTTP facade instead
class RiotApi
{
    /**
     * @throws GuzzleException
     */
    public static function get(string $url, string $server = null, array $data = []): array
    {
        return static::fetch('GET', $url, $server, $data);
    }

    /**
     * @throws GuzzleException
     */
    public static function post(string $url, string $server = null, array $data = []): array
    {
        return static::fetch('POST', $url, $server, $data);
    }

    /**
     * @throws GuzzleException
     */
    private static function fetch(string $method, string $url, string $server = null, array $data = []): array
    {
        $config = config('riot-api-connector');

        if ($server) {
            $base_uri = 'https://'.$server.'.'.$config['url'];
        } else {
            $base_uri = 'https://'.$config['url'];
        }

        $client = new Client([
            'base_uri' => $base_uri,
        ]);

        $data = array_merge_recursive($data, [
            'headers' => [
                'X-Riot-Token' => $config['token'],
            ],
        ]);

        $response = $client->request($method, $url, $data);

        return json_decode($response->getBody(), true);
    }
}
