<?php

namespace RiotApiConnector\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use RiotApiConnector\Models\Champion\Champion;

class Tag extends Model
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
