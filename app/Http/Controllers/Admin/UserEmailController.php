<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserEmailController extends Controller
{
    /**
     * @param $user_id
     */
    public function index($user_id)
    {
        $user = User::find($user_id);

        if(!$user){
            return abort(404);
        }

        return view('admin.user.send_email')->with('user', $user);
    }
}
