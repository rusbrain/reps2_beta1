<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameVersion extends Model
{
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replays()
    {
        return $this->hasMany('App\Replay', 'game_version_id');
    }
}
