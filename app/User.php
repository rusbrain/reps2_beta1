<?php

namespace App;

use App\Traits\ModelRelations\UserRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property integer $id
 * @property string $name
 * @property integer $email
 * @property Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
*/
class User extends Authenticatable
{
    use Notifiable, UserRelation, SoftDeletes;

    /**
     * Using table name
     *
     * @var string
     */
    protected $table='users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at','user_role_id', 'country_id', 'score', 'homepage', 'isq', 'skype', 'vk_link', 'fb_link',
        'signature', 'file_id', 'mouse', 'keyboard', 'headphone', 'mousepad', 'birthday', 'last_ip', 'is_ban', 'rep_allow', 'rep_buy',
        'rep_sell', 'view_signs', 'view_avatars', 'updated_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get user if his password id not update
     *
     * @param $email
     * @return mixed
     */

    public static function getOld($email)
    {
        return User::where('email', $email)->where('updated_password', 0)->first();
    }

    /**
     * @return array
     */
    public static function getUserWithReputationQuery()
    {
        return ['user' => function($query){
            $query->withTrashed()
                ->withCount([
                'reputation as rep_positive' => function($query){
                    $query->where('rating', 1);
                },
                'reputation as rep_negative' => function($query){
                    $query->where('rating', -1);
                }])
            ->with('country');
        }];
    }

    /**
     * @param $rating
     * @param $user_id
     */
    public static function updateRating($rating, $user_id)
    {
        \DB::update('update users set rating = rating + (?) where id = ?', [$rating, $user_id]);
    }

    /**
     * Get all data of user
     *
     * @param $user_id
     * @return mixed
     */
    public static function getAllUserProfile($user_id)
    {
        return User::where('id', $user_id)->with('role', 'avatar', 'user_friends.friend_user.avatar',
            'user_friendly.user.avatar', 'answers_to_questions.question.answers')
            ->with(['topics' => function($query){
                $query->with('section', 'preview_image')
                    ->orderBy('created_at', 'desc')->limit(5);
            }])
            ->with(['replays' => function($query){
                $query->with('map', 'type','first_country','second_country', 'game_version')
                    ->orderBy('created_at', 'desc')->limit(5);
            }])
            ->with(['user_galleries' => function($query){
                $query->with('file')
                    ->orderBy('created_at', 'desc')->limit(9);
            }])
            ->withCount('topics','user_galleries', 'files',
                'user_friends', 'user_friendly', 'ignore_users', 'ignored_users', 'gallery_comments', 'replay_comments',
                'topic_comments', 'gosu_replay', 'replay', 'answers_to_questions')
            ->first();
    }

    /**
     * Get user profile data
     *
     * @param $user_id
     * @return mixed
     */
    public static function getUserProfile($user_id)
    {
        return User::find($user_id)->load('role', 'avatar');
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getUserDataById($id)
    {
        return User::where('id',$id)
            ->with('role', 'avatar', 'friends', 'friendly')
            ->withCount( 'positive', 'negative', 'comments')
            ->withCount('user_galleries', 'topics', 'replay', 'gosu_replay', 'topic_comments', 'replay_comments', 'gallery_comments')
            ->first();
    }
}