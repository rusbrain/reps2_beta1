<?php

namespace App;

use App\Traits\ModelRelations\UserRelation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

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
     * @param $user_id
     */
    public static function recountRating($user_id)
    {
        $ratings = UserReputation::where('recipient_id', $user_id)->get();
        $sum = 0;
        foreach ($ratings as $rating){
            $sum += $rating->rating;
        }

        User::where('id', $user_id)->update(['rating' => $sum]);
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
     * Update user data profile
     *
     * @param Request $request
     * @param $user_id
     * @return mixed
     */
    public static function updateData(Request $request, $user_id)
    {
        $user = User::find($user_id);

        $user_data = $request->all();

        foreach ($user_data as $key=>$item){
            if (is_null($item)){
                unset($user_data[$key]);
            }
        }

        if (isset($user_data['country'])){
            $user_data['country_id'] = $user_data['country'];
            unset($user_data['country']);
        }

        if ($request->file('avatar')){
            $title = 'Аватар '.$user->name;
            $file = File::storeFile($request->file('avatar'), 'avatars', $title);

            $user_data['file_id'] = $file->id;
        }

        if(Auth::user()->role?(Auth::user()->role->name != 'admin'):true){
            unset($user_data['user_role_id']);
        }

        $user->update($user_data);

        return User::find($user_id);
    }

    /**
     * Update user points
     *
     * @param $user_id
     * @param bool $point true - increment and false - decrement
     */
    public static function updatePoints($user_id, bool $point)
    {
        if($point){
            User::where('id', $user_id)->increment('points',1);
        } else{
            User::where('id', $user_id)->decrement('points',1);
        }
    }

    /**
     * Search users
     *
     * @param Request $request
     * @return User|\Illuminate\Database\Eloquent\Builder
     */
    public static function searchUser(Request $request)
    {
        $users = User::with('role','avatar', 'country')->withCount('topics', 'replays','user_galleries');

        if ($request->has('search') && null !==$request->get('search')){
            $users->where(function ($query) use ($request)
            {
                $query->where('id', $request->get('search'))
                    ->orWhere('name', 'like', '%'.$request->get('search').'%')
                    ->orWhere('email', 'like', '%'.$request->get('search').'%');
            });
        }

        if ($request->has('country') && null !==$request->get('country')){
            $users->where('country_id', $request->get('country'));
        }

        if ($request->has('email_verified') && null !==$request->get('email_verified')){
            if ($request->get('email_verified') == 0){
                $users->whereNull('email_verified_at');
            } else{
                $users->whereNotNull('email_verified_at');
            }
        }

        if ($request->has('role') && null !==$request->get('role')){
            $users->where('user_role_id', $request->get('role'));
        }

        if ($request->has('is_ban') && null !==$request->get('is_ban')){
            $users->where('is_ban', $request->get('is_ban'));
        }

        if($request->has('sort') && null !==$request->get('sort')){
            $users->orderBy($request->get('sort'));
        } else{
            $users->orderBy('created_at', 'desc');
        }

        return $users;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public static function removeUser(User $user)
    {
        $user->user_galleries()->delete();
//        $user->dialogues()->delete();
        $user->user_friends()->delete();
        $user->user_friendly()->delete();

        User::where('id', $user->id)->delete();
    }
}