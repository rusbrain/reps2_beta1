<?php

namespace App\Observers;

use App\ForumTopic;

class ForumTopicPointsObserver extends BasePointsObserver
{
    /**
     * Handle the forum topic "created" event.
     *
     * @param  \App\ForumTopic  $forumTopic
     * @return void
     */
    public function created(ForumTopic $forumTopic)
    {
        $this->created_point($forumTopic->user_id);
    }

    /**
     * Handle the forum topic "deleted" event.
     *
     * @param  \App\ForumTopic  $forumTopic
     * @return void
     */
    public function deleted(ForumTopic $forumTopic)
    {
        $this->deleted_point($forumTopic->user_id);
    }

    /**
     * Handle the forum topic "restored" event.
     *
     * @param  \App\ForumTopic  $forumTopic
     * @return void
     */
    public function restored(ForumTopic $forumTopic)
    {
        $this->restored_point($forumTopic->user_id);
    }
}
