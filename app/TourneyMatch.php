<?php

namespace App;

use App\Traits\ModelRelations\TourneyMatchRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\TourneyList;

class TourneyMatch extends Model
{
    use Notifiable, TourneyMatchRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'tourney_matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tourney_id',
        'match_id',
        'round',
        'round_id',
        'player1_id',
        'player2_id',
        'player1_score',
        'player2_score',
        'win_score',
        'winner_action',
        'winner_value',
        'looser_action',
        'looser_value',
        'played',
        'rep1',
        'rep2',
        'rep3',
        'rep4',
        'rep5',
        'rep6',
        'rep7'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @param $tourney_id
     * @param $round_id
     * @return map_link
     */
    public static function getTourneyRoundMap($tourney_id, $round_id)
    {

        $tourney = TourneyList::where('id', $tourney_id)->first();
        $mapArray = explode(",", $tourney->maps);
        $mapsCount = count($mapArray);
        $mapIndex =  $round_id % $mapsCount;
        $tourneyMap = ReplayMap::where('id', $mapArray[$mapIndex])->first();
        if ($tourneyMap) {
            return '<a href="'.$tourneyMap->url.'" target="_blank">'.$tourneyMap->name.'</a>';
        }
        return '';

    }
}
