<?php

namespace RiotApiConnector\Models;

use Database\Factories\RegionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method whereName(string $name)
 */
class Region extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    protected static function newFactory(): RegionFactory
    {
        return RegionFactory::new();
    }
}
