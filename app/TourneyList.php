<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourneyList extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='tourney_lists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tourney_id',    
        'admin_id',
        'name',
        'place',
        'prize_pool',
        'status',
        'visible',
        'maps',
        'rules_link',
        'vod_link',
        'logo_link',
        'map_selecttype',
        'importance',
        'is_ranking',
        'password',
        'checkin_time'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
