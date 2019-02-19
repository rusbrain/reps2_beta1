<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;

class UserEmailController extends Controller
{
    /**
     * Get view for send mail to user
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
