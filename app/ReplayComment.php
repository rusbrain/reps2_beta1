<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplayComment extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'replay_comments';

    /**
     * Relations. Comments topic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function replay()
    {
        return $this->belongsTo('App\Replay', 'replay_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
