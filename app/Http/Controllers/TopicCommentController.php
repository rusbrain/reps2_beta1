<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\TopicCommentStoreRequest;

class TopicCommentController extends CommentController
{
    /**
     * Relation id
     *
     * @var string
     */
    protected static $relation = Comment::RELATION_FORUM_TOPIC;

    /**
     * View name
     *
     * @var string
     */
    protected static $view_name = 'forum.topic.index';

    /**
     * object name with 'id'
     *
     * @var string
     */
    protected static $name_id = 'topic_id';

    /**
     * Store a newly created resource in storage.
     *
     * @param TopicCommentStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TopicCommentStoreRequest $request)
    {
        return $this->storeComment($request);
    }
}
