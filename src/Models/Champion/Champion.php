<?php

namespace RiotApiConnector\Models\Champion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Translatable\HasTranslations;

class Champion extends Model
{
    use HasTranslations;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'key', 'riot_id', 'name', 'title', 'blurb', 'partype',
    ];

    public array $translatable = [
        'name', 'title', 'blurb', 'partype',
    ];

    public function info(): HasOne
    {
        return $this->hasOne(ChampionInfo::class);
    }

    public function image(): HasOne
    {
        return $this->hasOne(ChampionImage::class);
    }

    public function stats(): HasOne
    {
        return $this->hasOne(ChampionStat::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(ChampionTag::class);
    }
}
