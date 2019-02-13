<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * @param $object_name
     * @param $id
     * @return array
     */
    public function getComments($object_name, $id)
    {
        $relation   = Comment::getObjectRelation($object_name);
        $comments   = [];

        if ($relation){
            $comments = Comment::where('relation', $relation)->where('object_id', $id)->with('user.avatar')->orderBy('created_at', 'desc')->paginate(20);
        }

        $table      = (string) view('admin.comment')        ->with(['data' => $comments]);
        $pagination = (string) view('admin.user.pagination')->with(['data' => $comments]);

        return ['table' => $table, 'pagination' => $pagination];
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeComment($id)
    {
        Comment::find($id)->delete();
        return back();
    }
}
