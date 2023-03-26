<?php

namespace Anthonyrave\RiotApiConnector\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RiotApi
{
    /**
     * @param string $url
     * @param string $server
     * @return array
     * @throws GuzzleException
     */
    public static function get(string $url, string $server): array
    {
        return static::call('GET', $url, $server);
    }

    /**
     * @param string $url
     * @param string $server
     * @return array
     * @throws GuzzleException
     */
    public static function post(string $url, string $server): array
    {
        return static::call('POST', $url, $server);
    }

    /**
     * @param string $method
     * @param string $url
     * @param string|null $server
     * @return array
     * @throws GuzzleException
     */
    private static function call(string $method, string $url, string $server = null): array
    {
        $config = config('riot-api-connector');

        if ($server) {
            $base_uri = 'https://' . $server . '.' . $config['base_uri'];
        } else {
            $base_uri = 'https://' . $config['base_uri'];
        }

        $client = new Client([
            'base_uri' => $base_uri,
        ]);

        $response = $client->request($method, $url, [
            'headers' => [
                'X-Riot-Token' => $config['api_key'],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
