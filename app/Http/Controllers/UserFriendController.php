<?php

namespace App\Http\Controllers;

use App\IgnoreUser;
use App\User;
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
        if (IgnoreUser::me_ignore($user_id)){
            return abort(403);
        }

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
     * @param bool $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFriendsList($user_id = false)
    {
        if ($user_id){
            $user = User::find($user_id);
        } else {
            $user = Auth::user();
        }

        $friends = $user->user_friends()->with('friend_user')->get()->transform(function ($friend){
            $friend->friend_user->friendly_data = $friend->created_at;
            return $friend->friend_user;
        });

        $friendly = $user->user_friendly()->with('user')->get()->transform(function ($friend){
            $friend->user->friendly_data = $friend->created_at;
            return $friend->user;
        });

        return view('user.friends')->with(['friends'=>$friends, 'friendly' => $friendly]);
    }
}
