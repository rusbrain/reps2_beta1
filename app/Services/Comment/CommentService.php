<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 13:52
 */

namespace App\Services\Comment;


use App\Comment;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    /**
     * @param $data
     * @param $relation
     * @param $object_id
     * @return mixed
     */
    public static function create($data, $relation, $object_id){
        $data['user_id'] = Auth::id();
        $data['relation'] = $relation;
        $data['object_id'] = (int)$object_id;

        Comment::create($data);

        return $object_id;
    }

    /**
     * @param Request $request
     * @param $id
     * @param $relation
     */
    public static function update(Request $request, $id, $relation)
    {
        $replay_data = $request->validated();
        $replay_data['title'] = $replay_data['title']??null;

        Comment::where('id', $id)->where('relation', $relation)->update($replay_data);
    }
}