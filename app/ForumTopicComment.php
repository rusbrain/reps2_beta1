<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumTopicComment extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'forum_topic_comments';

    /**
     * Relations. Comments topic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo('App\ForumTopic', 'topic_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
