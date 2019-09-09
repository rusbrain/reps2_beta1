<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User, TourneyList, TourneyPlayer};
use App\Services\Tournament\TourneyService;
use App\Services\Base\{BaseDataService, UserViewService};

class TournamentController extends Controller
{
    /**
     * @param tournament_id
     * @return mixed
     */
    public function show($tournament_id)
    {
        $tourney = TourneyList::find($tournament_id);
        $tourney_players =TourneyService::getTourneyPlayers($tournament_id) ;
        $tourney_matches = TourneyService::getTourneyMatches($tournament_id);
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return view('tourney.list')->with('request', '');
    }

    /**
     *
     */
    public function paginate()
    {
        $tournaments = TourneyService::getTournaments();
        return [
            'tournaments'   => UserViewService::getTournaments($tournaments),
            'pagination' => UserViewService::getPagination($tournaments)
        ];
    }
}
