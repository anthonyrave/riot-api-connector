<?php

namespace RiotApiConnector\Database\Eloquent;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\RequestException;
use RiotApiConnector\Exceptions\InvalidApiKeyException;

class ApiBuilder extends Builder
{
    /** @var ApiModel */
    public $model;

    /**
     * @throws RequestException
     * @throws InvalidApiKeyException
     * @throws BindingResolutionException
     */
    public function first($columns = ['*']): Model|Collection|ApiBuilder|null
    {
        $record = parent::first($columns);

        if ($record) {
            return $record;
        }

        if ($this->model->request) {
            $data = $this->model->request->fetch();
            $this->model->request = null;

            return $this->model->adapter($this->model)->newFromApi($data);
        }

        return null;
    }

    /**
     * @throws RequestException
     * @throws InvalidApiKeyException
     * @throws BindingResolutionException
     */
    public function get($columns = ['*']): Model|Collection|ApiBuilder
    {
        $record = parent::get($columns);

        if (! $record->isEmpty()) {
            return $record;
        }

        if ($this->model->request) {
            $data = $this->model->request->fetch();
            $this->model->request = null;

            return $this->model->adapter($this)->newFromApi($data);
        }

        return new Collection();
    }
}
