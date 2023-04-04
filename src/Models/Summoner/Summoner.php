<?php

namespace RiotApiConnector\Models\Summoner;

use Illuminate\Database\Eloquent\Model;

class Summoner extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'summonerId', 'accountId', 'puuid', 'name', 'profileIconId', 'revisionDate', 'summonerLevel',
    ];
}
