<?php

namespace App;

use App\Observers\CommentObserver;
use App\Services\Comment\CommentService;
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
        'relation',
        'negative_count',
        'positive_count'
    ];

    /**
     * Get pagination comments of object with relations
     *
     * @param $object
     * @return mixed
     */
    public static function getObjectComments($object)
    {
        return $object->comments()->with(User::getUserWithReputationQuery())->withCount('positive', 'negative')
            ->orderBy('created_at')->paginate(20);
    }

    /**
     * @param $object_name
     * @param $id
     * @return array
     */
    public static function getComment($object_name, $id)
    {
        $relation = CommentService::getObjectRelation($object_name);

        if ($relation){
            $comments = Comment::where('relation', $relation)->where('object_id', $id)->with('user.avatar')->orderBy('created_at', 'desc');
        } else {
            $comments = Comment::where('id' < 0);
        }

        return $comments->paginate(20);
    }
}
