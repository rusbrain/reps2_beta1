<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplayCommentStoreRequest;
use App\ReplayComment;

class ReplayCommentController extends CommentController
{
    /**
     * Model name
     *
     * @var string
     */
    protected static $model = ReplayComment::class;

    /**
     * View name
     *
     * @var string
     */
    protected static $view_name = 'replay.get';

    /**
     * object name with 'id'
     *
     * @var string
     */
    protected static $name_id = 'replay_id';
    /**
     * Store a newly created resource in storage.
     *
     * @param ReplayCommentStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReplayCommentStoreRequest $request)
    {
        self::storeComment($request);
        return redirect()->route('replay.get', ['id' => $request->get('replay_id')]);
    }
}
