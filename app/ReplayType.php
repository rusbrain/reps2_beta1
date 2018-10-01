<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplayType extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'replay_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
