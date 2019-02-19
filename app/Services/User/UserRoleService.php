<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.19
 * Time: 9:36
 */

namespace App\Services\User;


use App\User;
use App\UserRole;

class UserRoleService
{
    /**
     * @param $role_id
     */
    public static function remove($role_id)
    {
        User::where('user_role_id', $role_id)->update(['user_role_id' => 0]);
        UserRole::where('id', $role_id)->delete();
    }
}