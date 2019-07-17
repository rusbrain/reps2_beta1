<?php


namespace App\Traits\ModelRelations;


trait UserActivityLogRelation
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
