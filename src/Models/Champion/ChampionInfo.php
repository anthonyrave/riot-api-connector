<?php

namespace RiotApiConnector\Models\Champion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChampionInfo extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'attack', 'defense', 'magic', 'difficulty',
    ];

    public function champion(): BelongsTo
    {
        return $this->belongsTo(Champion::class);
    }
}
