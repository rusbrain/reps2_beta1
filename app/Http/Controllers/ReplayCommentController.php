<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\ReplayCommentStoreRequest;

class ReplayCommentController extends CommentController
{
    /**
     * Relation id
     *
     * @var string
     */
    protected $relation = Comment::RELATION_REPLAY;

    /**
     * View name
     *
     * @var string
     */
    protected $view_name = 'replay.get';

    /**
     * object name with 'id'
     *
     * @var string
     */
    protected $name_id = 'replay_id';
    /**
     * Store a newly created resource in storage.
     *
     * @param ReplayCommentStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReplayCommentStoreRequest $request)
    {
        return $this->storeComment($request);
    }
}
