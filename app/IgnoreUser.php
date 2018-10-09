<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    /**
     * I ignore this user?
     *
     * @param $user_id
     * @return bool
     */
    public static function i_ignore($user_id)
    {
        return IgnoreUser::where('user_id', Auth::id())->where('ignored_user_id', $user_id)->count() > 0;
    }

    /**
     * This user ignore me?
     *
     * @param $user_id
     * @return bool
     */
    public static function me_ignore($user_id)
    {
        return IgnoreUser::where('user_id', $user_id)->where('ignored_user_id', Auth::id())->count() > 0;
    }
}
