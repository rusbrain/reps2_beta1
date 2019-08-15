<?php

namespace App\Services\Tournament;

use App\{
    File, TourneyList, Services\Base\UserViewService, Services\User\UserService, User
};
use App\Http\Controllers\TournamentController;
use App\Services\Base\FileService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->where('start_time','>', Carbon::now()->format('Y-m-d H:i:s'))
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
            ->with(['win_player' => function($query){
                $query->with(['user'=> function($q){
                    $q->with('avatar')->withTrashed();
                }]);
            }])
            ->paginate(20);
        return $tournaments; 
    }

}
