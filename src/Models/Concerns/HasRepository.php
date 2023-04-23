<?php

namespace RiotApiConnector\Models\Concerns;

use Illuminate\Contracts\Container\BindingResolutionException;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Repositories\Repository;

trait HasRepository
{
    /**
     * Get a new repository instance for the model.
     *
     * @param mixed ...$params
     * @return Repository<static>
     *
     * @throws BindingResolutionException
     */
    public static function repository(...$params): Repository
    {
        return static::newRepository(...$params) ?: Repository::repositoryForModel(get_called_class());
    }

    /**
     * Create a new repository instance for the model.
     *
     * @return Repository<static>
     */
    protected static function newRepository()
    {
        //
    }
}
