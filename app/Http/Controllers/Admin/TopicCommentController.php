<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\ForumTopic;
use App\Http\Controllers\CommentController;
use App\Http\Requests\CommentUpdateRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TopicCommentController extends CommentController
{
    /**
     * Relation id
     *
     * @var string
     */
    protected  $relation = Comment::RELATION_FORUM_TOPIC;

    /**
     * View name
     *
     * @var string
     */
    protected  $view_name = 'forum.topic.index';

    /**
     * object name with 'id'
     *
     * @var string
     */
    protected  $name_id = 'topic_id';

    /**
     * Model class
     *
     * @var string
     */
    protected $model = ForumTopic::class;

    /**
     * Save comment to forum topic from admin panel
     *
     * @param CommentUpdateRequest $request
     * @param $topic_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendComment(CommentUpdateRequest $request, $topic_id)
    {
        $data = $request->validated();
        ForumTopic::where('id', $topic_id)->update('commented_at', Carbon::now());

        $this->createComment($data, $topic_id);

        return back();
    }

    /**
     * Delete comment from id
     *
     * @param $comment_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function commentRemove($comment_id)
    {
        Comment::find($comment_id)->delete();

        return back();
    }
}
