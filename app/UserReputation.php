<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReputation extends Model
{
    const RELATION_FORUM_TOPIC  = 1;
    const RELATION_REPLAY       = 2;
    const RELATION_USER_GALLERY = 3;

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
     * Relations. Reputations user sender
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    /**
     * Relations. Reputations user sender
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo('App\User', 'recipient_id');
    }

    /**
     * Relations. Reputations user sender
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo('App\ForumTopic', 'object_id')->where('relation', self::RELATION_FORUM_TOPIC);
    }

    /**
     * Relations. Reputations user sender
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function replay()
    {
        return $this->belongsTo('App\Replay', 'object_id')->where('relation', self::RELATION_REPLAY);
    }

    /**
     * Relations. Reputations user sender
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gallery()
    {
        return $this->belongsTo('App\UserGallery', 'object_id')->where('relation', self::RELATION_USER_GALLERY);
    }

    /**
     * Refresh user Rating
     *
     * @param $user_id
     */
    public static function refreshUserRating($user_id)
    {
        $val = UserReputation::where('recipient_id', $user_id)->sum('rating');
        User::where('id', $user_id)->update(['rating'=>$val]);
    }

    public static function refreshObjectRating($class_name, $object_id, $relation_id)
    {
        $val = UserReputation::where('object_id', $object_id)->where('relation',$relation_id)->sum('rating');
        $class_name::where('id', $object_id)->update(['rating'=>$val]);
    }
}