<?php

namespace App\Traits\ModelRelations;

trait TourneyMatchRelation
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File', 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player1()
    {
        return $this->belongsTo('App\TourneyPlayer', 'player1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player2()
    {
        return $this->belongsTo('App\TourneyPlayer', 'player2_id');
    }
}
