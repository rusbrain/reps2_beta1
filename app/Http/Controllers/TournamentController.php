<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Services\Replay\ReplayService, User, TourneyList, TourneyPlayer, File};
use App\Services\Tournament\TourneyService;
use App\Services\Base\{BaseDataService, UserViewService};
use Illuminate\Support\Facades\Storage;

class TournamentController extends Controller
{
    /**
     * @param tournament_id
     * @return mixed
     */
    public function show($tournament_id)
    {
        $tourney = TourneyList::where('id', $tournament_id)->with('admin_user')->first();
        $tourney_players = TourneyService::getTourneyPlayers($tournament_id);
        $tourney_matches = TourneyService::getTourneyMatches($tournament_id);
        return view('tourney.show')->with(['tourney' => $tourney, 'players' => $tourney_players, 'matches' => $tourney_matches]);
    }

    /**
     * Download reps file
     * @param $file_id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */

    public function download($file_id)
    {
        try {
            $file = File::where('id', $file_id)->first();
            $link = $file->link;
            if (!$link) {
                throw new \DomainException('Файл отсутствует');
            }
            $file_link = str_replace('/storage', 'public', $link);

            if (!Storage::exists($file_link)) {
                throw new \DomainException('Файл отсутствует');
            }

            return Storage::download($file_link);

        } catch (\DomainException $e) {
            return view('error', ['error' => $e->getMessage()]);
        }
    }

    /**
     * @return mixed
     */
    public
    function index()
    {
        return view('tourney.list')->with('request', '');
    }

    /**
     *
     */
    public
    function paginate()
    {
        $tournaments = TourneyService::getTournaments();
        return [
            'tournaments' => UserViewService::getTournaments($tournaments),
            'pagination' => UserViewService::getPagination($tournaments)
        ];
    }
}
