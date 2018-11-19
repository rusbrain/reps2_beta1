<?php

namespace App\Observers;

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
        $this->addRatingCount($userReputation);
    }

    /**
     * Handle the user reputation "updated" event.
     *
     * @param  \App\UserReputation  $userReputation
     * @return void
     */
    public function updated(UserReputation $userReputation)
    {
        $this->reversRatingCount($userReputation);
    }

    /**
     * Handle the user reputation "deleted" event.
     *
     * @param  \App\UserReputation  $userReputation
     * @return void
     */
    public function deleting(UserReputation $userReputation)
    {
        $this->removeRatingCount($userReputation);

    }

    /**
     * Handle the user reputation "restored" event.
     *
     * @param  \App\UserReputation  $userReputation
     * @return void
     */
    public function restored(UserReputation $userReputation)
    {
        $this->addRatingCount($userReputation);
    }

    /**
     * @param $userReputation
     */
    protected function addRatingCount($userReputation)
    {
        $object = $this->getObject($userReputation);
        $user = $this->getUser($userReputation);

        if($object){
            if($userReputation->rating == 1){
                $object->positive_count++;
                $object->rating++;
            }else{
                $object->negative_count++;
                $object->rating--;
            }

            $object->save();
        }

        if($user){
            if($userReputation->rating == 1){
                $user->positive_count++;
                $user->rating++;
            }else{
                $user->negative_count++;
                $user->rating--;
            }

            $user->save();
        }
    }


    /**
     * @param $userReputation
     */
    protected function removeRatingCount($userReputation)
    {
        $object = $this->getObject($userReputation);
        $user = $this->getUser($userReputation);

        if($object){
            if($userReputation->rating == 1){
                $object->positive_count--;
                $object->rating--;
            }else{
                $object->negative_count--;
                $object->rating++;
            }

            $object->save();
        }

        if($user){
            if($userReputation->rating == 1){
                $user->positive_count--;
                $user->rating--;
            }else{
                $user->negative_count--;
                $user->rating++;
            }

            $user->save();
        }
    }

    /**
     * @param $userReputation
     */
    protected function reversRatingCount($userReputation)
    {
        $object = $this->getObject($userReputation);
        $user = $this->getUser($userReputation);

        if($object){
            $object->positive_count = $object->positive_count + ($userReputation->rating);
            $object->negative_count = $object->negative_count - ($userReputation->rating);
            $object->rating = $object->rating + ($userReputation->rating);
            $object->save();
        }

        if($user){
            $user->positive_count = $user->positive_count + ($userReputation->rating);
            $user->negative_count = $user->negative_count - ($userReputation->rating);
            $user->rating = $user->rating + ($userReputation->rating);
            $user->save();
        }
    }

    /**
     * @param $userReputation
     * @return null
     */
    protected function getObject($userReputation)
    {
        $object = null;
        switch ($userReputation->relation){
            case UserReputation::RELATION_FORUM_TOPIC:
                $object = ForumTopic::find($userReputation->object_id);
                break;
            case UserReputation::RELATION_REPLAY:
                $object = Replay::find($userReputation->object_id);
                break;
            case UserReputation::RELATION_USER_GALLERY:
                $object = UserGallery::find($userReputation->object_id);
                break;
        }

        return $object;
    }

    /**
     * @param $userReputation
     * @return mixed
     */
    protected function getUser($userReputation)
    {
        return User::find($userReputation->recipient_id);
    }
}
