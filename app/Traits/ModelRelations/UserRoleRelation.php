<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 15:11
 */

namespace App\Traits\ModelRelations;


trait UserRoleRelation
{
    /**
     * Relations. Roles users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}