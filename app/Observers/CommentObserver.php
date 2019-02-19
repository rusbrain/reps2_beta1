<?php

namespace App\Observers;

use App\{Comment, ForumTopic, Replay, UserGallery};

class CommentObserver extends BasePointsObserver
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
        $this->created_point($comment->user_id);
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
        $this->deleted_point($comment->user_id);
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
        $this->restored_point($comment->user_id);
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
