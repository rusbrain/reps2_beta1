<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Requests\CommentUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicCommentController extends Controller
{


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
        $data['user_id'] = Auth::id();
        $data['relation'] = Comment::RELATION_FORUM_TOPIC;
        $data['object_id'] = $topic_id;

        Comment::create($data);

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
        Comment::where('id', $comment_id)->delete();

        return back();
    }
}
