<?php

namespace App\Observers;

use App\Comment;
use App\ForumTopic;
use App\Replay;
use App\User;
use App\UserGallery;
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
        UserReputation::refreshUserRating($userReputation->recipient_id);
        UserReputation::refreshObjectRating($userReputation->object_id, $userReputation->relation);
    }

    /**
     * Handle the user reputation "updated" event.
     *
     * @param  \App\UserReputation  $userReputation
     * @return void
     */
    public function updated(UserReputation $userReputation)
    {
        UserReputation::refreshUserRating($userReputation->recipient_id);
    }

    /**
     * Handle the user reputation "deleted" event.
     *
     * @param  \App\UserReputation  $userReputation
     * @return void
     */
    public function deleting(UserReputation $userReputation)
    {
        UserReputation::refreshUserRating($userReputation->recipient_id);

    }

    /**
     * Handle the user reputation "restored" event.
     *
     * @param  \App\UserReputation  $userReputation
     * @return void
     */
    public function restored(UserReputation $userReputation)
    {
        UserReputation::refreshUserRating($userReputation->recipient_id);
    }
}
