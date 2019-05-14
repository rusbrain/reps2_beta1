<?php

namespace App\Http\Controllers;

use App\{IgnoreUser, User, UserFriend};
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
        try{
            if (IgnoreUser::me_ignore($user_id)){
                throw new \DomainException('Данный пользователь Вас игнорирует');
            }
            if(!UserFriend::createFriend($user_id)){
                throw new \DomainException('Пользователь уже добавлен в список друзей');
            }
            return back();

        } catch (\DomainException $e) {
            return redirect()->route('error',['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove user from friends list
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFriend($user_id)
    {
        UserFriend::removeFriend($user_id);
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

        $friends = UserFriend::getFriends($user);
        $friendly = UserFriend::getFriendlies($user);

        return view('user.friends')->with(['friends'=>$friends, 'friendly' => $friendly]);
    }
}
