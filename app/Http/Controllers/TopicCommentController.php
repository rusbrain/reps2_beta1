<?php

namespace App\Http\Controllers;

use App\ForumTopicComment;
use Illuminate\Http\Request;
use App\Http\Requests\TopicCommentStoreRequest;
use App\Http\Requests\TopicCommentUpdateRequest;
use Illuminate\Support\Facades\Auth;

class TopicCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param TopicCommentStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TopicCommentStoreRequest $request)
    {
        $comment_data = [
            'topic_id' => $request->get('topic_id'),
            'content'=> $request->get('content'),
            'user_id' => Auth::id()
        ];

        if ($request->has('title') && $request->get('title') != ''){
            $comment_data['title'] = $request->get('title');
        }

        ForumTopicComment::create($comment_data);

        return redirect()->route('forum.topic.index', ['id' => $request->get('topic_id')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TopicCommentUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TopicCommentUpdateRequest $request, $id)
    {
        $comment_data = [
            'content'=> $request->get('content')
        ];

        if ($request->has('title') && $request->get('title') != ''){
            $comment_data['title'] = $request->get('title');
        } else {
            $comment_data['title'] = null;
        }

        $comment = ForumTopicComment::where('id', $id)->update($comment_data);

        return redirect()->route('forum.topic.index', ['id' => $comment->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = ForumTopicComment::fint($id);

        $topic_id = $comment->topic_id;

        if (!$comment){
            return abort(404);
        }

        if ($comment->user_id != Auth::id()){
            return abort(403);
        }

        $comment->delete();

        return redirect()->route('forum.topic.index', ['id' => $topic_id]);
    }
}
