<?php

namespace App;

use App\Traits\ModelRelations\UserFriendRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
