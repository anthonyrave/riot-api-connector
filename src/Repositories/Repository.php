<?php

namespace RiotApiConnector\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RiotApiConnector\Http\Requests\PendingRequest;
use RiotApiConnector\Models\Region;

abstract class Repository
{
    protected static string $model;

    protected static string $namespace = 'RiotApiConnector\\';

    protected ?Region $region;

    protected PendingRequest $request;

    protected Builder $query;

    public function __construct(?string $regionName = null)
    {
        if ($regionName) {
            $this->region = Region::query()
                ->where('name', $regionName)
                ->first();
        }
        /** @var Model $model */
        $model = static::$model ?? self::resolveModelName(get_called_class());
        $this->query = $model::query();
    }

    public static function resolveModelName(string $repositoryName): string
    {
        $packageNamespace = static::$namespace;

        $repositoryName = Str::startsWith($repositoryName, $packageNamespace.'Repositories\\')
            ? Str::after($repositoryName, $packageNamespace.'Repositories\\')
            : Str::after($repositoryName, $packageNamespace);

        $modelName = Str::before($repositoryName, 'Repository');

        return static::$namespace.'Models\\'.$modelName;
    }

    public static function resolveRequestName(string $repositoryName): string
    {
        $packageNamespace = static::$namespace;

        $repositoryName = Str::startsWith($repositoryName, $packageNamespace.'Repositories\\')
            ? Str::after($repositoryName, $packageNamespace.'Repositories\\')
            : Str::after($repositoryName, $packageNamespace);

        $requestName = Str::before($repositoryName, 'Repository').'Request';

        return static::$namespace.'Http\\Requests\\'.$requestName;
    }

    public function get()
    {
        if (! config('riot_api_connector.cache.enabled')) {
            $this->fromApi();
        }
    }

    public function fromApi()
    {
        return $this->request->get();
    }
}
