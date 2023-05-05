<?php

namespace RiotApiConnector\Adapters;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class Adapter
{
    protected static string $namespace = 'RiotApiConnector\\';

    public static function resolveAdapterName(string $modelName): string
    {
        $packageNamespace = static::$namespace;

        $modelName = Str::startsWith($modelName, $packageNamespace.'Models\\')
            ? Str::after($modelName, $packageNamespace.'Models\\')
            : Str::after($modelName, $packageNamespace);

        return $packageNamespace.'Adapters\\'.$modelName.'Adapter';
    }

    /**
     * @throws BindingResolutionException
     */
    public static function new(array $params = []): Adapter
    {
        return app()->make(get_called_class(), $params);
    }

    /**
     * @param  class-string<Model>  $modelName
     *
     * @throws BindingResolutionException
     */
    public static function adapterForModel(string $modelName): Adapter
    {
        /** @var Adapter $adapter */
        $adapter = static::resolveAdapterName($modelName);

        return $adapter::new();
    }

    abstract public function newFromApi(array $data): Model|Collection;
}
