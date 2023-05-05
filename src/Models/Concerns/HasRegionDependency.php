<?php

namespace RiotApiConnector\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Repositories\Repository;

/**
 * @property int $region_id
 * @property Region $region
 */
trait HasRegionDependency
{
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function newQuery(): Builder
    {
        return $this->registerGlobalScopes($this->newQueryWithoutScopes())->whereBelongsTo(App::getRegion());
    }

    public static function repository(array $params = []): Repository
    {
        $repository = static::newRepository($params) ?: Repository::repositoryForModel(get_called_class(), $params);
        return $repository->region(App::getRegion());
    }
}
