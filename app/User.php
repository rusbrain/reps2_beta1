<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

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
        'rep_sell', 'view_signs', 'view_avatars', 'updated_password',
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
     * Relations. Users country
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }

    /**
     * Relations. Users role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\UserRole', 'user_role_id');
    }

    /**
     * Relations. Users files
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('App\File');
    }

    /**
     * Relations. Users avatar
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar()
    {
        return $this->belongsTo('App\File', 'file_id');
    }

    /**
     * Relations. Users sending reputation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function send_reputation()
    {
        return $this->hasMany('App\UserReputation', 'sender_id');
    }

    /**
     * Relations. Users reputation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reputation()
    {
        return $this->hasMany('App\UserReputation', 'recipient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positive()
    {
        return $this->hasMany('App\UserReputation', 'recipient_id')->where('rating',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function negative()
    {
        return $this->hasMany('App\UserReputation', 'recipient_id')->where('rating',-1);
    }

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
     * Get last users token by function
     *
     * @param $function
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|null|object
     */
    public function user_email_token($function)
    {
        return $this->hasMany('App\UserEmailToken')->where('function',$function)->orderBy('created_at', 'desc')->first();
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers_to_questions()
    {
        return $this->hasMany('App\InterviewUserAnswers', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_galleries()
    {
        return $this->hasMany('App\UserGallery');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics()
    {
        return $this->hasMany('App\ForumTopic', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replays()
    {
        return $this->hasMany('App\Replay', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replay()
    {
        return $this->hasMany('App\Replay', 'user_id')->where('user_replay', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gosu_replay()
    {
        return $this->hasMany('App\Replay', 'user_id')->where('user_replay', 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topic_comments()
    {
        return $this->hasMany('App\Comment', 'user_id')->where('relation', Comment::RELATION_FORUM_TOPIC);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replay_comments()
    {
        return $this->hasMany('App\Comment', 'user_id')->where('relation', Comment::RELATION_REPLAY);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gallery_comments()
    {
        return $this->hasMany('App\Comment', 'user_id')->where('relation', Comment::RELATION_USER_GALLERY);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ignore_users()
    {
        return $this->hasMany('App\IgnoreUser', 'ignored_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ignored_users()
    {
        return $this->hasMany('App\IgnoreUser', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_friends()
    {
        return $this->hasMany('App\UserFriend', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_friendly()
    {
        return $this->hasMany('App\UserFriend', 'friend_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends()
    {
        return $this->belongsToMany('App\User', 'user_friends', 'user_id', 'friend_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friendly()
    {
        return $this->belongsToMany('App\User', 'user_friends','friend_user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\UserMessage', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dialogues()
    {
        return $this->belongsToMany('App\Dialogue', 'user_messages');
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
                $query->with('map', 'type','first_country','second_country')
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
}