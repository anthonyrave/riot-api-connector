<?php

namespace RiotApiConnector\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface Adapter
{
    public function newFromApi(array $data): Model|Collection;
}