<?php

namespace App;

use App\Observers\UserReputationObserver;
use App\Traits\ModelRelations\UserReputationRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserReputation extends Model
{
    use Notifiable, UserReputationRelation;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserReputationObserver::class,
        'deleting' => UserReputationObserver::class,
        'deleted' => UserReputationObserver::class,
        'restored' => UserReputationObserver::class,
        'updated' => UserReputationObserver::class,
    ];

    const RELATION_FORUM_TOPIC  = 1;
    const RELATION_REPLAY       = 2;
    const RELATION_USER_GALLERY = 3;
    const RELATION_COMMENT      = 4;

    /**
     * Using table name
     *
     * @var string
     */
    protected $table='user_reputations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_id',
        'sender_id',
        'recipient_id',
        'comment',
        'rating',
        'relation'
    ];

    /**
     * Refresh user Rating
     *
     * @param $user_id
     */
    public static function refreshUserRating($user_id)
    {
        $positive = UserReputation::where('recipient_id', $user_id)->where('rating', '1')->count();
        $negative = UserReputation::where('recipient_id', $user_id)->where('rating', '-1')->count();
        $val = $positive - $negative;

        User::where('id', $user_id)->update(['rating'=>$val, 'negative_count' => $negative, 'positive_count' => $positive]);
    }

    /**
     * Refresh object Rating
     *
     * @param $object_id
     * @param $relation_id
     */
    public static function refreshObjectRating($object_id, $relation_id)
    {
        $class_name = self::getModel($relation_id);
        $positive = UserReputation::where('object_id', $object_id)->where('relation',$relation_id)->where('rating', '1')->count();
        $negative = UserReputation::where('object_id', $object_id)->where('relation',$relation_id)->where('rating', '-1')->count();
        $val = $positive - $negative;

        $class_name::where('id', $object_id)->update(['rating'=>$val, 'negative_count' => $negative, 'positive_count' => $positive]);
    }

    /**
     * @param $relation_id
     * @return null|string
     */
    protected static function getModel($relation_id)
    {
        $model = null;
        switch ($relation_id){
            case UserReputation::RELATION_FORUM_TOPIC:
                $model = ForumTopic::class;
                break;
            case UserReputation::RELATION_REPLAY:
                $model = Replay::class;
                break;
            case UserReputation::RELATION_USER_GALLERY:
                $model = UserGallery::class;
                break;
            case UserReputation::RELATION_COMMENT:
                $model = Comment::class;
                break;
        }

        return $model;
    }
}