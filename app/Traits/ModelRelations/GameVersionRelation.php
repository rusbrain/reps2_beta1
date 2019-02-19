<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:53
 */

namespace App\Traits\ModelRelations;

trait GameVersionRelation
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replays()
    {
        return $this->hasMany('App\Replay', 'game_version_id');
    }
}