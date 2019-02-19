<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 15:00
 */

namespace App\Traits\ModelRelations;

use App\Comment;

trait UserRelation
{
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
}