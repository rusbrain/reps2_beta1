<?php

namespace App\Http\Controllers\Admin;

use App\{Comment, ForumTopic};
use App\Http\Controllers\CommentController;
use App\Http\Requests\CommentUpdateRequest;
use Carbon\Carbon;

class TopicCommentController extends CommentController
{
    /**
     * Relation id
     *
     * @var string
     */
    public  $relation = Comment::RELATION_FORUM_TOPIC;

    /**
     * View name
     *
     * @var string
     */
    public  $view_name = 'forum.topic.index';

    /**
     * object name with 'id'
     *
     * @var string
     */
    public  $name_id = 'topic_id';

    /**
     * Model class
     *
     * @var string
     */
    public $model = ForumTopic::class;

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
}
