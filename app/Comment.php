<?php

namespace App;

use App\Observers\CommentObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Comment extends Model
{
    use Notifiable;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created'   => CommentObserver::class,
        'deleted'   => CommentObserver::class,
        'restored'  => CommentObserver::class,
    ];

    const RELATION_FORUM_TOPIC  = 1;
    const RELATION_REPLAY       = 2;
    const RELATION_USER_GALLERY = 3;

    /**
     * Using table name
     *
     * @var string
     */
    protected $table='comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'object_id',
        'title',
        'content',
        'relation'
    ];

    /**
     * Relations. Comments topic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo('App\ForumTopic', 'object_id');
    }

    /**
     * Relations. Comments replay
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function replay()
    {
        return $this->belongsTo('App\Replay', 'object_id');
    }

    /**
     * Relations. Comments user gallery
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gallery()
    {
        return $this->belongsTo('App\UserGallery', 'object_id');
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
        return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_COMMENT)->where('rating',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function negative()
    {
        return $this->hasMany('App\UserReputation', 'object_id')->where('relation', UserReputation::RELATION_COMMENT)->where('rating','-1');
    }
}
