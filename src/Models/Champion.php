<?php

namespace RiotApiConnector\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 *
 * @method static insert(array $champions = [])
 * @method static truncate()
 * @method static Champion findOrFail(int $id)
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
