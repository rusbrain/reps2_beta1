<?php

namespace App\Http\Controllers;

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
    protected $relation;

    /**
     * View name
     *
     * @var string
     */
    protected $view_name;

    /**
     * Route name
     *
     * @var string
     */
    protected $route_name;

    /**
     * object name with 'id'
     *
     * @var string
     */
    protected $name_id = 'topic_id';

    /**
     * Model class
     *
     * @var string
     */
    protected $model;

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

        $this->createComment($data, $data[$this->name_id]);

        return redirect()->route($this->route_name, ['id' => $data[$this->name_id]]);
    }

    /**
     * @param $data
     * @param $object_id
     */
    protected function createComment($data, $object_id){
        $data['user_id'] = Auth::id();
        $data['relation'] = $this->relation;
        $data['object_id'] = (int)$object_id;

        if(isset($data[$this->name_id])){
            unset($data[$this->name_id]);
        }

        Comment::create($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     */
    public function updateComment(Request $request, $id)
    {
         $replay_data = $request->validated();
         $replay_data['title'] = $replay_data['title']??null;

         Comment::where('id', $id)->where('relation', $this->relation)->update($replay_data);
    }
}
