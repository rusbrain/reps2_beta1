<?php

namespace App\Observers;

use App\UserGallery;

class UserGalleryPointsObserver extends BasePointsObserver
{
    /**
     * Handle the user gallery "created" event.
     *
     * @param  \App\UserGallery  $userGallery
     * @return void
     */
    public function created(UserGallery $userGallery)
    {
        $this->created_point($userGallery->user_id);
    }

    /**
     * Handle the user gallery "deleted" event.
     *
     * @param  \App\UserGallery  $userGallery
     * @return void
     */
    public function deleted(UserGallery $userGallery)
    {
        $this->deleted_point($userGallery->user_id);
    }

    /**
     * Handle the user gallery "restored" event.
     *
     * @param  \App\UserGallery  $userGallery
     * @return void
     */
    public function restored(UserGallery $userGallery)
    {
        $this->restored_point($userGallery->user_id);
    }
}
