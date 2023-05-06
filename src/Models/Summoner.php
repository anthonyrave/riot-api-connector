<?php

namespace RiotApiConnector\Models;

use Database\Factories\SummonerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use RiotApiConnector\Database\Eloquent\ApiModel;
use RiotApiConnector\Database\Eloquent\Relations\HasManyFromApi;
use RiotApiConnector\Models\Concerns\HasRegionDependency;

/**
 * @property int $id
 * @property string $encrypted_summoner_id
 * @property string $encrypted_account_id
 * @property string $encrypted_puuid
 * @property string $summoner_name
 * @property int profile_icon_id
 * @property int revision_date
 * @property Collection $masteries
 * @property Collection $ranks
 * @method Builder whereSummonerName(string $summonerName)
 * @method Builder whereEncryptedSummonerId(string $encryptedSummonerId)
 */
class Summoner extends ApiModel
{
    use HasFactory;
    use HasRegionDependency;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'region_id', 'encrypted_summoner_id', 'encrypted_account_id', 'encrypted_puuid', 'summoner_name',
        'profile_icon_id', 'revision_date', 'summoner_level',
    ];

    protected static function newFactory(): SummonerFactory
    {
        return SummonerFactory::new();
    }

    public function ranks(): HasManyFromApi
    {
        return $this->hasManyFromApi(Rank::class);
    }

    public function masteries(): HasManyFromApi
    {
        return $this->hasManyFromApi(Mastery::class);
    }
}
