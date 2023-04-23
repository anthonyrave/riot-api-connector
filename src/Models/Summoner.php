<?php

namespace RiotApiConnector\Models;

use Database\Factories\SummonerFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RiotApiConnector\Models\Concerns\Fetchable;
use RiotApiConnector\Models\Concerns\HasRepository;
use RiotApiConnector\Repositories\Repository;
use RiotApiConnector\Repositories\SummonerRepository;

/**
 * @property int $id
 * @property int $region_id
 * @property string $summoner_id
 * @property string $account_id
 * @property string $puuid
 * @property string $name
 * @property int profile_icon_id
 * @property int revision_date
 * @property Region $region
 */
class Summoner extends Model
{
    use HasFactory;
    use HasRepository;
    use Fetchable;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'region_id', 'summoner_id', 'account_id', 'puuid', 'name', 'profile_icon_id', 'revision_date', 'summoner_level',
    ];

    /**
     * @param Region $region
     * @return Repository
     * @throws BindingResolutionException
     */
    protected static function newRepository(Region $region): Repository
    {
        return SummonerRepository::new()->region(region: $region);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    protected static function newFactory(): SummonerFactory
    {
        return SummonerFactory::new();
    }

    public function masteries(): HasMany
    {
        return $this->hasMany(Mastery::class);
    }
}
