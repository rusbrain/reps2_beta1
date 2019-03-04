<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 13:52
 */

namespace App\Services\Comment;

use App\Comment;
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

    /**
     * @param $name
     * @return bool|int
     */
    public static function getObjectRelation($name)
    {
        switch ($name){
            case 'replay':
                return Comment::RELATION_REPLAY;
            case 'topic':
                return Comment::RELATION_FORUM_TOPIC;
            case 'gallery':
                return Comment::RELATION_USER_GALLERY;
        }

        return false;
    }
}