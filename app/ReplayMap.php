<?php

namespace App;

use App\Traits\ModelRelations\ReplayMapRelation;
use Illuminate\Database\Eloquent\Model;

class ReplayMap extends Model
{
    use ReplayMapRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'replay_maps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'url'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function findByTitle($mapTitle)
    {
        return ReplayMap::where('name', 'LIKE', "%$mapTitle%")
            ->orWhereRaw('? LIKE CONCAT("%", name, "%")', [$mapTitle])->first();
    }
}
