<?php

namespace RiotApiConnector\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RiotApiConnector\Models\Concerns\FromApi;

class Summoner extends Model
{
    use HasFactory;
    use FromApi;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'summoner_id', 'account_id', 'puuid', 'name', 'profile_icon_id', 'revision_date', 'summoner_level',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
