<?php

namespace App\Traits\ViewHelper;

use App\{
    TourneyList, TourneyPlayer, Services\Tournament\TourneyService
};

trait TournamentData
{
    /**
     * @return mixed
     */    
    public function getUpcomingTournaments()
    {
        if (!self::$instance->upcomingtournaments) {
            self::$instance->upcomingtournaments = TourneyService::getUpTournaments(5);
        }
        return self::$instance->upcomingtournaments;
    }
}