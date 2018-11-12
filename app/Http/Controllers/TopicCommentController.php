<?php

namespace App\Http\Controllers;

use App\Comment;
use App\ForumTopic;
use App\Http\Requests\TopicCommentStoreRequest;

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
     * Route name
     *
     * @var string
     */
    protected $route_name = 'forum.topic.index';

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
