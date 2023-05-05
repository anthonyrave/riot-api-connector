<?php

namespace RiotApiConnector\Database\Eloquent;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use RiotApiConnector\Adapters\Adapter;
use RiotApiConnector\Database\Eloquent\Relations\HasManyFromApi;
use RiotApiConnector\Http\Requests\PendingRequest;
use RiotApiConnector\Models\Concerns\Fetchable;
use RiotApiConnector\Repositories\Repository;

abstract class ApiModel extends Model
{
    use Fetchable;

    public ?PendingRequest $request = null;

    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'where')) {
            $property = Str::camel(str_replace('where', '', $method));
            $accessor = 'by_'.Str::snake($property);

            if ($endpoint = $this->endpoint($accessor)) {
                $this->request = new PendingRequest();
                $this->request->region = App::getRegion();
                $this->request->endpoint = $endpoint;
                $this->request->url_params = [
                    $property => $parameters[0],
                ];
            }

            return $this->forwardCallTo($this->newQuery(), $method, $parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @return Builder|ApiBuilder|ApiModel
     */
    public function newEloquentBuilder($query): Builder|ApiBuilder|static
    {
        return new ApiBuilder($query);
    }

    public function endpoints(): array
    {
        return config('riot.endpoints.'.Str::snake(class_basename(get_called_class())));
    }

    public function endpoint(string $endpoint): string
    {
        return $this->endpoints()[$endpoint];
    }

    /**
     * Get a new repository instance for the model.
     *
     * @param mixed ...$params
     * @return Repository<static>
     *
     * @throws BindingResolutionException
     */
    public static function repository(array $params = []): Repository
    {
        return static::newRepository($params) ?: Repository::repositoryForModel(get_called_class(), $params);
    }

    /**
     * Create a new repository instance for the model.
     *
     * @param array $params
     * @return Repository<static>
     */
    protected static function newRepository(array $params = [])
    {
        //
    }

    /**
     * Get a new Adapter instance for the model.
     *
     * @param $test
     * @return Adapter<static>
     *
     * @throws BindingResolutionException
     */
    public static function adapter($test): Adapter
    {
        return static::newAdapter($test) ?: Adapter::adapterForModel(get_called_class());
    }

    /**
     * Create a new adapter instance for the model.
     *
     * @return Adapter<static>
     */
    protected static function newAdapter($test)
    {
        //
    }

    /**
     * @param string $related
     * @param string|null $foreignKey
     * @param string|null $localKey
     * @return HasManyFromApi
     */
    public function hasManyFromApi(string $related, string $foreignKey = null, string $localKey = null): HasManyFromApi
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return $this->newHasManyFromApi(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey
        );
    }

    /**
     * @param ApiBuilder $query
     * @param Model $parent
     * @param string $foreignKey
     * @param string $localKey
     * @return HasManyFromApi
     */
    protected function newHasManyFromApi(ApiBuilder $query, Model $parent, string $foreignKey, string $localKey): HasManyFromApi
    {
        return new HasManyFromApi($query, $parent, $foreignKey, $localKey);
    }
}
