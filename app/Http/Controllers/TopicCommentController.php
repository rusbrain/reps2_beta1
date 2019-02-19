<?php

namespace App\Http\Controllers;

use App\{Comment, ForumTopic};
use App\Http\Requests\TopicCommentStoreRequest;
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
     * Route name
     *
     * @var string
     */
    public $route_name = 'forum.topic.index';

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
     * Store a newly created resource in storage.
     *
     * @param TopicCommentStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TopicCommentStoreRequest $request)
    {
        ForumTopic::where('id', $request->get('topic_id'))->update(['commented_at' => Carbon::now()]);
        return $this->storeComment($request);
    }
}
