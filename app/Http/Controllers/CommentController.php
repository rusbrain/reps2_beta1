<?php

namespace App\Http\Controllers;

use App\Services\Base\UserViewService;
use App\Services\Comment\CommentService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Http\Requests\CommentUpdateRequest;

class CommentController extends Controller
{
    /**
     * Relation id
     *
     * @var string
     */
    public $relation;

    public $relation_name;

    /**
     * View name
     *
     * @var string
     */
    public $view_name;

    /**
     * Route name
     *
     * @var string
     */
    public $route_name;

    /**
     * Route name for view edit comment page
     *
     * @var string
     */
    public $edit_route_name;

    /**
     * Route name for action attribute in edit comment form
     *
     * @var string
     */
    public $update_route_name;

    /**
     * object name with 'id'
     *
     * @var string
     */
    public $name_id = 'topic_id';

    /**
     * Model class
     *
     * @var string
     */
    public $model;

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        if(!($comment->user_id == Auth::user()->id && CommentService::checkCommentEdit($comment)) && !UserService::isAdmin() && !UserService::isModerator()){
            return redirect()->route('error',['id' => 'Вы не можете редактировать этот комментарий']);
        }

        return view('comments.comment-edit', [
            'comment' => $comment,
            'route' => $this->update_route_name,
            'relation' => $comment->relation,
            'comment_type' => $this->name_id,
            'object_id' => $comment->object_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommentUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        $id = $comment->id;
        if (Comment::find($id)){
            $this->updateComment($request, $comment);
            return redirect()->route($this->view_name, ['id' => $comment->object_id]);
        }

        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $object = Comment::find($id);

        if (!$object){
            return abort(404);
        }
        if ($object->user_id != Auth::id()){
            return abort(403);
        }

        $object_id = $object->object_id;
        $object->delete();

        return redirect()->route($this->view_name, ['id' => $object_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComment(Request $request)
    {
        $data = $request->validated();
        $id = $data[$this->name_id];

        if(isset($data[$this->name_id])){
            unset($data[$this->name_id]);
        }

        $id = CommentService::create($data, $this->relation, $id);
        return redirect()->route($this->route_name, ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     */
    public function updateComment(Request $request, $comment)
    {
        CommentService::update($request, $comment, $this->relation);
    }

    /**
     * @param $object
     * @param $id
     * @return array
     */
    public function pagination($id)
    {
        $comments   = Comment::getComment($this->relation_name, $id);
        return ['comments' => UserViewService::getComments($comments, $this->edit_route_name), 'pagination' => UserViewService::getPagination($comments)];
    }
}
