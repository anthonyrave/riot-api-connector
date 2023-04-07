<?php

namespace RiotApiConnector\Factories;

use Illuminate\Support\Str;
use RiotApiConnector\Http\Requests\PendingRequest;

abstract class RequestFactory
{
    protected static string $namespace = 'RiotApiConnector\\Http\\Requests\\';

    protected static string $packageNamespace = 'RiotApiConnector\\';

    private static string $request;

    public function __construct(
        protected readonly ?string $server = null
    ) {
    }

    public function request(string $endpoint, array $urlParams = []): PendingRequest
    {
        $request = static::$request ?? RequestFactory::resolveRequestName(get_called_class());

        return new $request($endpoint, $urlParams, $this->server);
    }

    public static function resolveRequestName(string $factoryName): string
    {
        $packageNamespace = static::$packageNamespace;

        $factoryName = Str::startsWith($factoryName, $packageNamespace.'Factories\\')
            ? Str::after($factoryName, $packageNamespace.'Factories\\')
            : Str::after($factoryName, $packageNamespace);

        return static::$namespace.Str::before($factoryName, 'Factory');
    }
}
