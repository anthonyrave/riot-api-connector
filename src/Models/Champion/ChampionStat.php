<?php

namespace RiotApiConnector\Models\Champion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChampionStat extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'hp', 'hpperlevel', 'mp', 'mpperlevel', 'movespeed', 'armor', 'armorperlevel', 'spellblock',
        'spellblockperlevel', 'attackrange', 'hpregen', 'hpregenperlevel', 'mpregen', 'mpregenperlevel', 'crit',
        'critperlevel', 'attackdamage', 'attackdamageperlevel', 'attackspeedperlevel', 'attackspeed',
    ];

    public function champion(): BelongsTo
    {
        return $this->belongsTo(Champion::class);
    }
}
