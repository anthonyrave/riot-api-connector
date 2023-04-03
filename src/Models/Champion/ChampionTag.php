<?php

namespace RiotApiConnector\Models\Champion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChampionTag extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function champions(): BelongsToMany
    {
        return $this->belongsToMany(Champion::class);
    }
}
