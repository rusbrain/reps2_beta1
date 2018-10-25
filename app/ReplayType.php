<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplayType extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'replay_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'title'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replay()
    {
        return $this->hasMany('App\Replay', 'type_id');
    }
}
