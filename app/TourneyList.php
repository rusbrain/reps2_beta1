<?php

namespace App;

use App\Services\Tournament\TourneyService;
use App\Traits\ModelRelations\TournamentRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class TourneyList extends Model
{
    use Notifiable, TournamentRelation;
    /**
     * var array
     */
    public static $status = array(
        0 => 'ANNOUNCE', 1 => 'REGISTRATION', 2 => 'CHECK-IN', 3 => 'GENERATION', 4 => 'STARTED', 5 => 'FINISHED'
    );

    public static $map_types = [
        0 => 'NONE', 1 => 'FIRSTBYREMOVING', 2 => 'FIRSTBYROUND'
    ];

    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'tourney_lists';

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

    /**
     * get_status
     * @param status_id
     * @return string
     */

    public static function getPrizePool($value)
    {
        return TourneyService::getPrizePool($value);
    }
}
