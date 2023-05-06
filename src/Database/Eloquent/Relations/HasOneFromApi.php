<?php

namespace RiotApiConnector\Database\Eloquent\Relations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\App;
use RiotApiConnector\Database\Eloquent\ApiBuilder;
use RiotApiConnector\Http\Requests\PendingRequest;

class HasOneFromApi extends HasOne
{
    public function __construct(ApiBuilder $query, Model $parent, $foreignKey, $localKey)
    {
        parent::__construct($query, $parent, $foreignKey, $localKey);
    }

    public function getResults()
    {
        $this->query->model->request = new PendingRequest();
        $this->query->model->request->region = App::getRegion();
        $this->query->model->request->endpoint = $this->query->model->endpoints()['default'];
        $this->query->model->request->url_params = [
            'encryptedSummonerId' => $this->parent->encrypted_summoner_id
        ];

        $this->query->parent = $this->parent;

        return ! is_null($this->getParentKey())
            ? $this->query->get()
            : $this->related->newCollection();
    }
}
