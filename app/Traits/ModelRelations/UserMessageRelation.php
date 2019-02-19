<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 15:07
 */

namespace App\Traits\ModelRelations;

trait UserMessageRelation
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dialogue()
    {
        return $this->belongsTo('App\Dialogue', 'dialogue_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}