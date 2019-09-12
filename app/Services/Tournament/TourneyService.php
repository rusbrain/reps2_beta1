<?php

namespace App\Services\Tournament;

use App\{File, ReplayMap, TourneyList, TourneyMatch, TourneyPlayer};
use Carbon\Carbon;

class TourneyService
{

    /**
     * @param int $limit
     * @return mixed
     */

    public static function getUpTournaments($limit = 5)
    {
        $upcoming_tournaments = TourneyList::where('visible', 1)
            ->where('start_time', '>', Carbon::now()->format('Y-m-d H:i:s'))
            ->orderBy('created_at', 'Desc')
            ->limit($limit)->get();
        return $upcoming_tournaments;
    }

    /**
     * @return mixed
     */
    public static function getTournaments()
    {
        $tournaments = TourneyList::orderBy('updated_at', 'Desc')
            ->withCount('players')
            ->withCount('checkin_players')
            ->with('admin_user')
            ->with(['win_player' => function ($query) {
                $query->with(['user' => function ($q) {
                    $q->with('avatar')->withTrashed();
                }]);
            }])
            ->paginate(20);
        return $tournaments;
    }

    /**
     * @return mixed
     */
    public static function getTourneyPlayers($tournament_id)
    {
        $players = TourneyPlayer::where('tourney_id', $tournament_id)->orderBy('check_in','desc')->orderByRaw('LENGTH(place_result)')->orderBy('place_result')
            ->with('user')
            ->get();
        return $players;

    }

    /**
     *
     * @return mixed
     */
    public static function getTourneyMatches($tournament_id)
    {
        $matches = TourneyMatch::where('tourney_id', $tournament_id)->orderBy('round_id')
            ->with(['player1' => function ($query) {
                $query->with(['user' => function ($q) {
                    $q->with('avatar')->withTrashed();
                }]);
            }])
            ->with(['player2' => function ($query) {
                $query->with(['user' => function ($q) {
                    $q->with('avatar')->withTrashed();
                }]);
            }])
            ->with(['file1','file2','file3','file4','file5','file6','file7'])
            ->get();
        $matches_array = array();
        $round_array = array();
        foreach ($matches as $match) {
            $matches_array[$match->round_id][] = $match;
            $round_array[$match->round_id] = $match->round;
        }

        return ['matches' => $matches_array, 'rounds'=>$round_array];
    }

    public static function getPrizePool($value)
    {
        $prize = explode(",", $value);
        $length = count($prize);
        return TourneyService::prize_prefix($value).TourneyService::prizeSum($value).$prize[$length -1];
    }

    public static function getPrize($id)
    {
        $tourney = TourneyList::where('id', $id)->first();
        $prize = explode(",", $tourney->prize_pool);
        $length = count($prize);
        $prizeArray = array();
        for($i = 1; $i < count($prize) - 1 ; $i++) {
            $prizeArray[] = $prize[0].$prize[$i].$prize[$length -1];
        }
        return $prizeArray;
    }

    public static function getMaps($id)
    {
        $tourney = TourneyList::where('id', $id)->first();
        $mapsArray = array();
        if (!empty($tourney->maps)) {
            $maps = explode(",", $tourney->maps);
            foreach ($maps as $map_id) {
                $mapsArray[] = ReplayMap::where('id', $map_id)->first();
            }
        }

        return $mapsArray;
    }

    /**
     * @param $t Tourney Id
     * @param $p Prize Sum
     * @param $c Players Count
     * @param string $pf Prize Prefix
     * @return int
     */
    public static function TImportance($t, $p, $c, $pf = '') {
        If ($t->is_ranking == 0) Return 0;
        $imp = 0;
        If (($p >=   10) && ($p <   25)) $imp +=  1;
        If (($p >=   25) && ($p <  100)) $imp +=  2;
        If (($p >=  100) && ($p <  250)) $imp +=  4;
        If (($p >=  250) && ($p < 1000)) $imp +=  7;
        If (($p >= 1000) && ($p < 2500)) $imp += 11;
        If (($p >= 2500))                $imp += 16;

        If (($c >=   8) && ($c <  16)) $imp +=  1;
        If (($c >=  16) && ($c <  32)) $imp +=  2;
        If (($c >=  32) && ($c <  64)) $imp +=  3;
        If (($c >=  64) && ($c < 128)) $imp +=  4;
        If (($c >= 128) && ($c < 256)) $imp +=  5;
        If (($c >= 256))               $imp +=  6;

        Switch ($pf) {
            case 'cc': $imp = -1; break;
        }

        Return $imp;
    }

    public static function ImpToStars($tournament_id) {
        $tourney = $tourney = TourneyList::where('id', $tournament_id)->first();
        $sum = TourneyService::prizeSum($tourney->prize_pool);
        $prefix = TourneyService::prize_prefix($tourney->prize_pool);
        $playersCount = TourneyPlayer::where('tourney_id', $tournament_id)->where('check_in', 1)->count();

        $imp = TourneyService::TImportance($tourney, $sum, $playersCount, $prefix);
        $r = '';
        $simp = $imp;
        /** Special Tour Ranks */
        switch ($imp) {
            case -1:
                $r .= '<img src = "/images/icons/cc.png">';
                break;
        }
        /** --- */
        If ($imp == 0) $r .= '<img title="'.$simp.'" src = "/images/icons/starsnone.png">';
        While ($imp >= 4) {
            $r .= '<img title="'.$simp.'" src = "/images/icons/stargold.png">';
            $imp -= 4;
        }
        For ($I = 1; $I <= $imp; $I++) $r .= '<img title="'.$simp.'" src = "/images/icons/starsilver.png">';
        Return $r;
    }

    public static function prizeSum($prize_pool)
    {
        $prize = explode(",", $prize_pool);
        $sum = 0;
        for($i = 1; $i < count($prize) - 1 ; $i++) {
            $sum += $prize[$i];
        }
        return $sum;
    }

    public static function prize_prefix($prize_pool)
    {
        $prize = explode(",", $prize_pool);
        return $prize[0];
    }
}
