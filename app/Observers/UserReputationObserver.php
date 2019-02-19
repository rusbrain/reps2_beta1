<?php

namespace App\Observers;

use App\Services\Rating\RatingService;
use App\UserReputation;

class UserReputationObserver
{
    /**
     * Handle the user reputation "created" event.
     *
     * @param  \App\UserReputation  $userReputation
     * @return void
     */
    public function created(UserReputation $userReputation)
    {
        RatingService::refreshUserRating($userReputation->recipient_id);
        RatingService::refreshObjectRating($userReputation->object_id, $userReputation->relation);
    }

    /**
     * Handle the user reputation "updated" event.
     *
     * @param  \App\UserReputation  $userReputation
     * @return void
     */
    public function updated(UserReputation $userReputation)
    {
        RatingService::refreshUserRating($userReputation->recipient_id);
    }

    /**
     * Handle the user reputation "deleted" event.
     *
     * @param  \App\UserReputation  $userReputation
     * @return void
     */
    public function deleting(UserReputation $userReputation)
    {
        RatingService::refreshUserRating($userReputation->recipient_id);

    }

    /**
     * Handle the user reputation "restored" event.
     *
     * @param  \App\UserReputation  $userReputation
     * @return void
     */
    public function restored(UserReputation $userReputation)
    {
        RatingService::refreshUserRating($userReputation->recipient_id);
    }
}
