<?php

namespace App;

use App\Traits\ModelRelations\GameVersionRelation;
use Illuminate\Database\Eloquent\Model;

class GameVersion extends Model
{
    use GameVersionRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='game_versions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
