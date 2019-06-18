<?php

namespace App\Http\Controllers;

use App\{Comment, Replay};
use App\Http\Requests\ReplayCommentStoreRequest;

class ReplayCommentController extends CommentController
{
    /**
     * Relation id
     *
     * @var string
     */
    public $relation = Comment::RELATION_REPLAY;

    public $relation_name = 'replay';

    public $edit_route_name = 'replay.comment.edit';

    public $update_route_name = 'replay.comment.update';

    /**
     * View name
     *
     * @var string
     */
    public $view_name = 'replay.get';

    /**
     * Route name
     *
     * @var string
     */
    public $route_name = 'replay.get';

    /**
     * object name with 'id'
     *
     * @var string
     */
    public $name_id = 'replay_id';

    /**
     * Model class
     *
     * @var string
     */
    public $model = Replay::class;

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
