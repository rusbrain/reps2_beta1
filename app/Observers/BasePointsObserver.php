<?php

namespace App\Observers;

use App\User;

class BasePointsObserver
{
    /**
     * @param $user_id
     */
    protected function created_point($user_id)
    {
        User::updatePoints($user_id, true);
    }

    /**
     * @param $user_id
     */
    protected function deleted_point($user_id)
    {
        User::updatePoints($user_id, false);
    }

    /**
     * @param $user_id
     */
    protected function restored_point($user_id)
    {
        User::updatePoints($user_id, false);
    }
}
