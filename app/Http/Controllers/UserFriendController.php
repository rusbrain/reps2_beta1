<?php

namespace App\Http\Controllers;

use App\UserFriend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFriendController extends Controller
{
    /**
     * Add user to friends list
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addFriend($user_id)
    {
        UserFriend::create([
            'user_id' => Auth::id(),
            'friend_user_id' => $user_id
        ]);

        return back();
    }

    /**
     * Remove user from friends list
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFriend($user_id)
    {
        UserFriend::where('user_id', Auth::id())->where('friend_user_id', $user_id)->delete();

        return back();
    }

    /**
     * Get user friend list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFriendsList()
    {
        $friends = Auth::user()->user_friends()->with('friend_user')->get()->transform(function ($friend){
            return $friend->friend_user;
        });

        $friendly = Auth::user()->user_friendly()->with('user')->get()->transform(function ($friend){
            return $friend->user;
        });

        return view('user.friends')->with(['friends'=>$friends, 'friendly' => $friendly]);
    }
}
