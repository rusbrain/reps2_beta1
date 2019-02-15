<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 15:06
 */

namespace App\Traits\ModelRelations;


trait UserEmailTokenRelation
{
    /**
     * Relations. Tokens user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}