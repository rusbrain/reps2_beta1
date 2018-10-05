<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplayUserRating extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'replay_user_ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'replay_id', 'comment', 'rating'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function replay()
    {
        return $this->belongsTo('App\Replay');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}