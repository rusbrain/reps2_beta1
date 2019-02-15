<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:30
 */

namespace App\Traits\ModelRelations;


trait CountryRelation
{
    /**
     * Relations. Countries users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replays1()
    {
        return $this->hasMany('App\Replay', 'first_country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replays2()
    {
        return $this->hasMany('App\Replay', 'second_country_id');
    }
}