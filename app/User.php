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
        'name', 'email', 'password', 'user_role_id', 'country_id'
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
}
