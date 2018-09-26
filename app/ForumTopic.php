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
       return $this->hasMany('App\ForumTopicRating')->where('positive',1)->where('negative',0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function negative()
    {
       return $this->hasMany('App\ForumTopicRating')->where('positive',0)->where('negative',1);
    }
}
