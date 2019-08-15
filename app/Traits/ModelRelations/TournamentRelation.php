<?php

namespace App\Traits\ModelRelations;

trait TournamentRelation
{
    /**
     * Relations. 
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany('App\TourneyPlayer', 'tourney_id');
    }

    public function checkin_players()
    {
        return $this->hasMany('App\TourneyPlayer', 'tourney_id')->where('check_in', 1);
    }
   
    public function win_player()
    {
        return $this->hasMany('App\TourneyPlayer', 'tourney_id')->where('place_result', 1);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function file()
    {
        return $this->belongsTo('App\File', 'file_id');
    }
    
}