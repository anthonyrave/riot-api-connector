<?php

namespace RiotApiConnector\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RiotApiConnector\Facades\RiotApi;
use RiotApiConnector\Http\Requests\PendingRequest;
use RiotApiConnector\Models\Region;

abstract class Repository
{
    protected static string $model;

    protected static string $adapter;

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

    public static function resolveAdapterName(string $repositoryName): string
    {
        $packageNamespace = static::$namespace;

        $repositoryName = Str::startsWith($repositoryName, $packageNamespace.'Repositories\\')
            ? Str::after($repositoryName, $packageNamespace.'Repositories\\')
            : Str::after($repositoryName, $packageNamespace);

        $requestName = Str::before($repositoryName, 'Repository').'Adapter';

        return static::$namespace.'Adapters\\'.$requestName;
    }

    public function get()
    {
        if (! RiotApi::useCache()) {
            return $this->fromApi();
        }

        $model = $this->fromDb();

        if ($model->expired) {
            return $this->fromApi();
        }

        return $model;
    }

    public function fromApi()
    {
        $data = $this->request->fetch();
        $adapter = static::$adapter ?? self::resolveAdapterName(get_called_class());

        return $adapter::newFromApi($data);
    }

    public function fromDb(): Model
    {
        return $this->query->first();
    }
}
