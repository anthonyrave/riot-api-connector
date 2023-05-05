<?php

namespace RiotApiConnector\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RiotApiConnector\Adapters\SummonerAdapter;
use RiotApiConnector\Http\Requests\PendingRequest;
use RiotApiConnector\Models\Region;

abstract class Repository
{
    protected static string $namespace = 'RiotApiConnector\\';

    protected static string $adapter;

    protected bool $isCollection = false;

    protected string $model;

    public function __construct(
        protected PendingRequest $request,
        protected Builder $query
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public static function new(array $params = []): Repository
    {
        return app()->make(get_called_class(), $params);
    }

    /**
     * @param Region|null $region
     * @param bool $useInQuery
     * @return $this
     */
    public function region(?Region $region = null, bool $useInQuery = true): static
    {
        if ($region === null) {
            return $this;
        }

        $this->request->region = $region;

        if ($useInQuery) {
            $this->query->where('region_id', $region->id);
        }

        return $this;
    }

    public function get(): Model|Collection
    {
        if (! config('riot_api_connector.cache.enabled')) {
            return $this->fromApi();
        }

        $result = $this->fromDb();

        if (! $result || ($result instanceof Collection && $result->isEmpty()) || $this->isExpired($result)) {
            return $this->fromApi();
        }

        return $result;
    }

    /**
     * @param Collection|Model $result
     * @return bool
     */
    public function isExpired(Model|Collection $result): bool
    {
        if ($this->isCollection) {
            return $result->contains(function ($model) {
                return $model->expired;
            });
        }

        return $result->expired;
    }

    public function fromApi(): Model|Collection
    {
        $data = $this->request->fetch();
        /** @var SummonerAdapter $adapter */
        $adapter = static::$adapter ?? self::resolveAdapterName(get_called_class());
        return $adapter::newFromApi($data, $this->request->region);
    }

    public function fromDb(): Model|Collection|null
    {
        return $this->isCollection ? $this->query->get() : $this->query->first();
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
     * @param  class-string<Model>  $modelName
     *
     * @throws BindingResolutionException
     */
    public static function repositoryForModel(string $modelName, array $params = []): Repository
    {
        /** @var Repository $repository */
        $repository = static::resolveRepositoryName($modelName);

        return $repository::new($params);
    }

    public function collection(): static
    {
        $this->isCollection = true;
        return $this;
    }

    public function model(): static
    {
        $this->isCollection = false;
        return $this;
    }
}
