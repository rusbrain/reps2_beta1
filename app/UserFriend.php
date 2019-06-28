<?php

namespace App;

use App\Services\User\UserService;
use App\Traits\ModelRelations\UserFriendRelation;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Support\Facades\Auth;

class UserFriend extends Model
{
    use SoftDeletes, UserFriendRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='user_friends';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'friend_user_id',
    ];

    /**
     * @param $user_id
     * @return bool
     */
    public static function createFriend($user_id)
    {
        if(UserService::isFriendExists(Auth::id(), $user_id)){
            return false;
        }
        UserFriend::create([
            'user_id' => Auth::id(),
            'friend_user_id' => $user_id
        ]);
        return true;
    }

    /**
     * @param $user_id
     */
    public static function removeFriend($user_id)
    {
        UserFriend::where('user_id', Auth::id())->where('friend_user_id', $user_id)->delete();
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getFriends(User $user)
    {
        $user_friends = $user->user_friends()->with('friend_user')->get()->transform(function ($friend){  
            if (isset($friend) && !empty($friend->friend_user)) {
                $friend->friend_user->friendly_data = $friend->created_at;                 
                return $friend->friend_user;
            }
        });
        return $user_friends;        
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getFriendlies(User $user)
    {
        return $user->user_friendly()->with('user')->get()->transform(function ($friend){
            if (isset($friend) && !empty($friend->user)) {
                $friend->user->friendly_data = $friend->created_at;
                return $friend->user;
            }
        });
    }
}
