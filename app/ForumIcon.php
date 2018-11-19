<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumIcon extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='forum_icons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icon'
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
    public function forum_topics()
    {
        return $this->hasMany('App\ForumTopic');
    }
}
