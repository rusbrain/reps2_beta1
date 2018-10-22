<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replay extends Model
{
    /**
     * @var array
     */
    public static $races = [
        1 => 'All',
        2 => 'Z',
        3 => 'T',
        4 => 'P',
    ];

    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'replays';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_replay', 'type_id','title', 'content', 'map_id', 'file_id',
        'game_version', 'championship', 'first_country_id', 'second_country_id',
        'first_matchup', 'second_matchup', 'rating', 'user_rating' ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\ReplayType', 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function map()
    {
        return $this->belongsTo('App\ReplayMap', 'map_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File', 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function first_country()
    {
        return $this->belongsTo('App\Country', 'first_country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function second_country()
    {
        return $this->belongsTo('App\Country', 'second_country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positive()
    {
        return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_REPLAY)->where('rating',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function negative()
    {
        return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_REPLAY)->where('rating','-1');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_rating()
    {
        return $this->hasMany('App\ReplayUserRating', 'replay_id');
    }

    /**
     * @param $rating
     * @param $replay_id
     */
    public static function updateRating($rating, $replay_id)
    {
        \DB::update('update replays set rating = rating + (?) where id = ?', [$rating, $replay_id]);
    }

    /**
     * Update value of user rating
     *
     * @param $replay_id
     */
    public static function updateUserRating($replay_id)
    {
        $count = ReplayUserRating::where('replay_id',[$replay_id])->count();
        $rating = $count?(ReplayUserRating::where('replay_id',[$replay_id])->sum('rating')/$count):0;

        Replay::where('id', $replay_id)->update(['user_rating'=>$rating]);
    }

    /**
     * Get query users replay
     *
     * @return mixed
     */
    public static function userReplay()
    {
        return Replay::where('user_replay', 1);
    }

    /**
     * Get query for gosu replay
     *
     * @return mixed
     */
    public static function gosuReplay()
    {
        return Replay::where('user_replay', 0);
    }

    /**
     * Relations. Topic comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'object_id')->where('relation', Comment::RELATION_REPLAY);
    }
}
