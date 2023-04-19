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
     * @return Repository<static>
     *
     * @throws BindingResolutionException
     */
    public static function repository(?Region $region = null): Repository
    {
        $repository = static::newRepository() ?: Repository::repositoryForModel(get_called_class());

        return $repository->region($region);
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
