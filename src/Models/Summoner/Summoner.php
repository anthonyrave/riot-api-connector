<?php

namespace RiotApiConnector\Models\Summoner;

use Database\Factories\SummonerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summoner extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'summonerId', 'accountId', 'puuid', 'name', 'profileIconId', 'revisionDate', 'summonerLevel',
    ];

    protected static function newFactory(): SummonerFactory
    {
        return new SummonerFactory();
    }
}
