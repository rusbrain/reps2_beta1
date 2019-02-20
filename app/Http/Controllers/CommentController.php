<?php

namespace App\Http\Controllers;

use App\Services\Base\UserViewService;
use App\Services\Comment\CommentService;
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
     * Update the specified resource in storage.
     *
     * @param CommentUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CommentUpdateRequest $request, $id)
    {
        if (Comment::find($id)){
            $this->updateComment($request, $id);
            return redirect()->route($this->view_name, ['id' => $id]);
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
    public function updateComment(Request $request, $id)
    {
        CommentService::update($request, $id, $this->relation);
    }

    /**
     * @param $object
     * @param $id
     * @return array
     */
    public function pagination($object, $id)
    {
        $comments   = Comment::getComment($object, $id);
        return ['comments' => UserViewService::getComments($comments), 'pagination' => UserViewService::getPagination($comments)];
    }
}
