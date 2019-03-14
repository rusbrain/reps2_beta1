<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:58
 */

namespace App\Traits\ModelRelations;

use App\{Comment,UserReputation};

trait ReplayRelation
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game_version()
    {
        return $this->belongsTo('App\GameVersion', 'game_version_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\ReplayType', 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function map()
    {
        return $this->belongsTo('App\ReplayMap', 'map_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File', 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function first_country()
    {
        return $this->belongsTo('App\Country', 'first_country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function second_country()
    {
        return $this->belongsTo('App\Country', 'second_country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positive()
    {
        return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_REPLAY)->where('rating',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function negative()
    {
        return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_REPLAY)->where('rating','-1');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_rating()
    {
        return $this->hasMany('App\ReplayUserRating', 'replay_id');
    }

    /**
     * Relations. Replay comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'object_id')->where('relation', Comment::RELATION_REPLAY);
    }
}