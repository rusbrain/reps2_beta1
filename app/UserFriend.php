<?php

namespace App;

use App\Traits\ModelRelations\UserFriendRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
     */
    public static function createFriend($user_id)
    {
        UserFriend::create([
            'user_id' => Auth::id(),
            'friend_user_id' => $user_id
        ]);
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
        return $user->user_friends()->with('friend_user')->get()->transform(function ($friend){
            $friend->friend_user->friendly_data = $friend->created_at;
            return $friend->friend_user;
        });
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getFriendlies(User $user)
    {
        return $user->user_friendly()->with('user')->get()->transform(function ($friend){
            $friend->user->friendly_data = $friend->created_at;
            return $friend->user;
        });
    }
}
