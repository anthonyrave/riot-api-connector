<?php

namespace RiotApiConnector\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MiniSeries extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = ['rank_id', 'losses', 'progress', 'target', 'wins'];

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }
}
