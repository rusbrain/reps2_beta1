<?php

namespace App\Traits\ModelRelations;

trait TourneyMatchRelation
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file1()
    {
        return $this->belongsTo('App\File', 'rep1');
    }
    public function file2()
    {
        return $this->belongsTo('App\File', 'rep2');
    }
    public function file3()
    {
        return $this->belongsTo('App\File', 'rep3');
    }
    public function file4()
    {
        return $this->belongsTo('App\File', 'rep4');
    }
    public function file5()
    {
        return $this->belongsTo('App\File', 'rep5');
    }
    public function file6()
    {
        return $this->belongsTo('App\File', 'rep6');
    }
    public function file7()
    {
        return $this->belongsTo('App\File', 'rep7');
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
