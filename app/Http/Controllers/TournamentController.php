<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User, TourneyList};
use App\Services\Tournament\TourneyService;
use App\Services\Base\{BaseDataService, UserViewService};

class TournamentController extends Controller
{
    /**
     * @return mixed
     */
    public function show($id)
    {

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
