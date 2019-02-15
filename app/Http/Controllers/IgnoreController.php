<?php

namespace App\Http\Controllers;

use App\IgnoreUser;
use App\Services\User\IgnoreService;
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
        IgnoreService::remove($user_id);
        return back();
    }

    /**
     * Get ignore user list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIgnoreList()
    {
        return view('user.ignore_list')->with('users', IgnoreService::getIgnoreList());
    }
}
