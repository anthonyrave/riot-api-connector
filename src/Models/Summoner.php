<?php

namespace RiotApiConnector\Models;

use Database\Factories\SummonerFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RiotApiConnector\Database\Eloquent\ApiModel;
use RiotApiConnector\Models\Concerns\Fetchable;
use RiotApiConnector\Models\Concerns\HasRegionDependency;
use RiotApiConnector\Models\Concerns\HasRepository;
use RiotApiConnector\Repositories\Repository;
use RiotApiConnector\Repositories\SummonerRepository;

/**
 * @property int $id
 * @property string $encrypted_summoner_id
 * @property string $encrypted_account_id
 * @property string $encrypted_puuid
 * @property string $summoner_name
 * @property int profile_icon_id
 * @property int revision_date
 * @property Collection $masteries
 * @method Builder whereSummonerName(string $summonerName)
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

    public function masteries(): HasMany
    {
        return $this->hasManyFromApi(Mastery::class);
    }
}
