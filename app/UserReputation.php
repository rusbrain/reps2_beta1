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
}