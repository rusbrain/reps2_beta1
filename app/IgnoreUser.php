<?php

namespace App;

use App\Traits\ModelRelations\IgnoreUserRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class IgnoreUser extends Model
{
    use IgnoreUserRelation;
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
