<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReputation extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='user_reputations';

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
}