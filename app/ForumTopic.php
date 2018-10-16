<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'forum_topics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['reps_id', 'reps_section', 'section_id', 'title', 'preview_content', 'content', 'user_id', 'reviews', 'start_on', 'preview_file_id'];

    /**
     * Relations. Topics section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo('App\ForumSection');
    }

    /**
     * Relations. Topic comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'object_id')->where('relation', Comment::RELATION_FORUM_TOPIC);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positive()
    {
       return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_FORUM_TOPIC)->where('rating',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function negative()
    {
       return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_FORUM_TOPIC)->where('rating',-1);
    }

    public function preview_image()
    {
        return $this->belongsTo('App\File', 'preview_file_id');
    }

    /**
     * @param $rating
     * @param $topic_id
     */
    public static function updateRating($rating, $topic_id)
    {
        \DB::update('update forum_topics set rating = rating + (?) where id = ?', [$rating, $topic_id]);
    }
}
