<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 13:52
 */

namespace App\Services\Comment;

use App\Comment;
use App\Services\Base\UserActivityLogService;
use Carbon\Carbon;
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
        $data['is_parsed'] = 1;

        $comment = Comment::create($data);

        UserActivityLogService::log(UserActivityLogService::EVENT_USER_COMMENT, $comment);

        return $object_id;
    }

    /**
     * @param Request $request
     * @param $id
     * @param $relation
     */
    public static function update(Request $request, Comment $comment)
    {
        $replay_data = $request->validated();
        $replay_data['title'] = $replay_data['title']??null;
        $replay_data['last_editor_id'] = Auth::id();
        $replay_data['is_parsed'] = 1;

        $comment->update($replay_data);
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

    public static function checkCommentEdit($comment)
    {
        if (is_null($comment->created_at)) {
            return false;
        }
        $time = Carbon::now()->diffInMinutes(Carbon::parse($comment->created_at));
        return $time <= 60;
    }
}
