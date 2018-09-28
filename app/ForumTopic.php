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
        return $this->hasMany('App\ForumTopicComment', 'topic_id');
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
       return $this->hasMany('App\UserReputation', 'topic_id')->where('rating',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function negative()
    {
       return $this->hasMany('App\UserReputation', 'topic_id')->where('rating',-1);
    }
}
