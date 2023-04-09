<?php

namespace RiotApiConnector\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

trait FromApi
{
    protected function expired(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $expirationDate = Carbon::createFromDate($attributes['updated_at'])
                    ->addSeconds(config('riot_api_connector.cache.duration'));

                return $expirationDate < Carbon::now();
            },
        );
    }
}
