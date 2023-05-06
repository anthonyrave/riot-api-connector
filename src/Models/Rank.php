<?php

namespace RiotApiConnector\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use RiotApiConnector\Database\Eloquent\ApiModel;

class Rank extends ApiModel
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'league_id', 'summoner_id', 'queue_type', 'tier', 'rank', 'league_points', 'wins', 'losses', 'hot_streak',
        'veteran', 'fresh_blood', 'inactive'
    ];

    public function miniSeries(): HasOne
    {
        return $this->hasOne(MiniSeries::class);
    }

    public function summoner(): BelongsTo
    {
        return $this->belongsTo(Summoner::class);
    }
}
