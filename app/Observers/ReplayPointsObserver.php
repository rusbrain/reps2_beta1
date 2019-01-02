<?php

namespace App\Observers;

use App\Replay;

class ReplayPointsObserver extends BasePointsObserver
{
    /**
     * Handle the replay "created" event.
     *
     * @param  \App\Replay  $replay
     * @return void
     */
    public function created(Replay $replay)
    {
        $this->created_point($replay->user_id);
    }

    /**
     * Handle the replay "deleted" event.
     *
     * @param  \App\Replay  $replay
     * @return void
     */
    public function deleted(Replay $replay)
    {
        $this->deleted_point($replay->user_id);
    }

    /**
     * Handle the replay "restored" event.
     *
     * @param  \App\Replay  $replay
     * @return void
     */
    public function restored(Replay $replay)
    {
        $this->restored_point($replay->user_id);
    }
}
