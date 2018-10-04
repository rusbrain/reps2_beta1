<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IgnoreUser extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='ignore_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ignored_user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ignored_user()
    {
        return $this->belongsTo('App\User', 'ignored_user_id');
    }
}
