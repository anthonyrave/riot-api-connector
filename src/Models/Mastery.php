<?php

namespace RiotApiConnector\Models;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RiotApiConnector\Models\Champion\Champion;
use RiotApiConnector\Models\Concerns\Fetchable;
use RiotApiConnector\Models\Concerns\HasRepository;
use RiotApiConnector\Repositories\MasteryRepository;

class Mastery extends Model
{
    use HasFactory;
    use HasRepository;
    use Fetchable;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'champion_id', 'summoner_id', 'champion_level', 'champion_points', 'last_play_time', 'champion_points_since_last_level',
        'champion_points_until_next_level', 'chest_granted', 'tokens_earned',
    ];

    public function champion(): BelongsTo
    {
        return $this->belongsTo(Champion::class);
    }

    public function summoner(): BelongsTo
    {
        return $this->belongsTo(Summoner::class);
    }

    /**
     * @param Summoner $summoner
     * @return MasteryRepository<static>
     *
     * @throws BindingResolutionException
     */
    public static function newRepository(Summoner $summoner): MasteryRepository
    {
        return MasteryRepository::new()->region(region: $summoner->region, useInQuery: false)->summoner(summoner: $summoner);
    }
}
