<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
    public function countries()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * Relations. Users role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\UserRole');
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function avatar()
    {
        return $this->hasOne('App\File');
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
            $query->withCount([
                'reputation as rep_positive' => function($query){
                    $query->where('rating', 1);
                },
                'reputation as rep_negative' => function($query){
                    $query->where('rating', -1);
                }]);
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers_to_questions()
    {
        return $this->hasMany('App\InterviewUserAnswers', 'user_id');
    }
}