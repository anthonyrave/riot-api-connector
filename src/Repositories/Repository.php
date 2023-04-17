<?php

namespace RiotApiConnector\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RiotApiConnector\Adapters\SummonerAdapter;
use RiotApiConnector\Http\Requests\PendingRequest;
use RiotApiConnector\Models\Region;

abstract class Repository
{
    protected static string $adapter;

    protected static string $namespace = 'RiotApiConnector\\';

    protected string $model;

    public function __construct(
        protected PendingRequest $request,
        protected Builder $query
    ) {
    }

    /**
     * @param  class-string<Model>  $modelName
     *
     * @throws BindingResolutionException
     */
    public static function repositoryForModel(string $modelName): Repository
    {
        /** @var Repository $repository */
        $repository = static::resolveRepositoryName($modelName);

        return $repository::new();
    }

    /**
     * @return class-string<Repository>
     */
    public static function resolveRepositoryName(string $modelName): string
    {
        $packageNamespace = static::$namespace;

        $modelName = Str::startsWith($modelName, $packageNamespace.'Models\\')
            ? Str::after($modelName, $packageNamespace.'Models\\')
            : Str::after($modelName, $packageNamespace);

        return $packageNamespace.'Repositories\\'.$modelName.'Repository';
    }

    /**
     * @throws BindingResolutionException
     */
    public static function new(): Repository
    {
        return app()->make(get_called_class());
    }

    public static function resolveModelName(string $repositoryName): string
    {
        $packageNamespace = static::$namespace;

        $repositoryName = Str::startsWith($repositoryName, $packageNamespace.'Repositories\\')
            ? Str::after($repositoryName, $packageNamespace.'Repositories\\')
            : Str::after($repositoryName, $packageNamespace);

        $modelName = Str::before($repositoryName, 'Repository');

        return $packageNamespace.'Models\\'.$modelName;
    }

    public function region(?Region $region = null): static
    {
        if ($region === null) {
            return $this;
        }

        $this->request->region = $region;
        $this->query->where('region_id', $region->id);

        return $this;
    }

    public function get(): Model
    {
        if (! config('riot_api_connector.cache.enabled')) {
            return $this->fromApi();
        }

        $model = $this->fromDb();

        if (! $model || $model->expired) {
            return $this->fromApi();
        }

        return $model;
    }

    public function fromApi(): Model
    {
        $data = $this->request->fetch();
        /** @var SummonerAdapter $adapter */
        $adapter = static::$adapter ?? self::resolveAdapterName(get_called_class());
        $model = $adapter::newFromApi($data, $this->request->region->id);

        return $model;
    }

    public static function resolveAdapterName(string $repositoryName): string
    {
        $packageNamespace = static::$namespace;

        $repositoryName = Str::startsWith($repositoryName, $packageNamespace.'Repositories\\')
            ? Str::after($repositoryName, $packageNamespace.'Repositories\\')
            : Str::after($repositoryName, $packageNamespace);

        $requestName = Str::before($repositoryName, 'Repository').'Adapter';

        return $packageNamespace.'Adapters\\'.$requestName;
    }

    public function fromDb(): ?Model
    {
        return $this->query->first();
    }
}
