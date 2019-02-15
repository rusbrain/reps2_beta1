<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:31
 */

namespace App\Traits\ModelRelations;


trait ForumIconRelation
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forum_topics()
    {
        return $this->hasMany('App\ForumTopic');
    }
}