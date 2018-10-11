<?php

namespace App\Http\Controllers;

use App\IgnoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IgnoreController extends Controller
{
    /**
     * Set ignore user
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setIgnore($user_id)
    {
        IgnoreUser::create([
            'user_id'           => Auth::id(),
            'ignored_user_id'   => $user_id
        ]);

        return back();
    }

    /**
     * Set not ignore user
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setNotIgnore($user_id)
    {
        IgnoreUser::where('user_id', Auth::id())->where('ignored_user_id', $user_id)->delete();

        return back();
    }

    /**
     * Get ignore user list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIgnoreList()
    {
        $users = IgnoreUser::where('user_id', Auth::id())->with('user.avatar')->paginate(50);

        return view('user.ignore_list')->with('users', $users);
    }
}
