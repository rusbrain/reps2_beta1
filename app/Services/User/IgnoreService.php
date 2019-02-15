<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 16:47
 */

namespace App\Services\User;


use App\IgnoreUser;
use Illuminate\Support\Facades\Auth;

class IgnoreService
{
    /**
     * @param $user_id
     */
    public static function remove($user_id)
    {
        IgnoreUser::where('user_id', Auth::id())->where('ignored_user_id', $user_id)->delete();
    }

    /**
     * @return mixed
     */
    public static function getIgnoreList()
    {
        return IgnoreUser::where('user_id', Auth::id())->with('user.avatar')->paginate(50);
    }
}