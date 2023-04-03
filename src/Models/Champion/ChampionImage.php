<?php

namespace RiotApiConnector\Models\Champion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChampionImage extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'full', 'sprite', 'group', 'x', 'y', 'w', 'h',
    ];

    public function champion(): BelongsTo
    {
        return $this->belongsTo(Champion::class);
    }
}
