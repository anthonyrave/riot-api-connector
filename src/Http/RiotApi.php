<?php

namespace Anthonyrave\RiotApiConnector\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class RiotApi
{
    /**
     * @param string $uri
     * @param string $server
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public static function get(string $uri, string $server): ResponseInterface
    {
        return static::call('GET', $uri, $server);
    }

    /**
     * @param string $uri
     * @param string $server
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public static function post(string $uri, string $server): ResponseInterface
    {
        return static::call('POST', $uri, $server);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param string|null $server
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private static function call(string $method, string $uri, string $server = null): ResponseInterface
    {
        $client = new Client([
            'base_uri' => 'https://' . $server ? $server . '.' : '' . config('riot-api-connector.base_uri'),
        ]);
        return $client->request($method, $uri);
    }
}
