<?php

namespace App;

use App\Observers\CommentObserver;
use App\Traits\ModelRelations\CommentRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Comment extends Model
{
    use Notifiable, CommentRelation;

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
     * @param $name
     * @param $id
     * @return int
     */
    public static function getObjectRelation($name)
    {
        switch ($name){
            case 'replay':
                return self::RELATION_REPLAY;
            case 'topic':
                return self::RELATION_FORUM_TOPIC;
            case 'gallery':
                return self::RELATION_USER_GALLERY;
        }

        return false;
    }
}
