<?php

namespace App\Http\Controllers;

use App\ForumTopicComment;
use App\Http\Requests\TopicCommentStoreRequest;

class TopicCommentController extends CommentController
{
    /**
     * Model name
     *
     * @var string
     */
    protected static $model = ForumTopicComment::class;

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
        self::storeComment($request);
        return redirect()->route('forum.topic.index', ['id' => $request->get('topic_id')]);
    }
}
