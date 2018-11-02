<?php

namespace App\Observers;

use App\Comment;
use App\ForumTopic;
use App\Replay;
use App\ReplayType;
use App\UserGallery;

class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        $this->addCommentCount($comment);
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        $this->removeCommentCount($comment);
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        $this->addCommentCount($comment);

    }

    /**
     * @param $comment
     */
    protected function addCommentCount($comment)
    {
        $object = $this->getObject($comment);

        if($object){
            $object->comments_count++;
            $object->save();
        }
    }

    /**
     * @param $comment
     */
    protected function removeCommentCount($comment)
    {
        $object = $this->getObject($comment);

        if($object){
            $object->comments_count--;
            $object->save();
        }
    }

    /**
     * @param $comment
     * @return null
     */
    protected function getObject($comment)
    {
        $object = null;
        switch ($comment->relation){
            case Comment::RELATION_FORUM_TOPIC:
                $object = ForumTopic::find($comment->object_id);
                break;
            case Comment::RELATION_REPLAY:
                $object = Replay::find($comment->object_id);
                break;
            case Comment::RELATION_USER_GALLERY:
                $object = UserGallery::find($comment->object_id);
                break;
        }

        return $object;
    }
}
