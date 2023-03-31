<?php

namespace RiotApiConnector\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array $champions = [])
 * @method static truncate()
 */
class Champion extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'key', 'name',
    ];
}
