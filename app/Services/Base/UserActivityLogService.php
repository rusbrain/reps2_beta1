<?php

namespace App\Services\Base;

use App\Comment;
use App\Services\Comment\CommentService;
use App\UserActivityLogEntry;
use App\UserReputation;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivityLogService
{
    const EVENT_USER_LOGIN = 'login';
    const EVENT_USER_LOGOUT = 'logout';
    const EVENT_USER_COMMENT = 'comment';
    const EVENT_USER_LIKE = 'like';

    protected static $eventTypeArgumentHandler = [
        self::EVENT_USER_LOGIN => 'parametersForLogin',
        self::EVENT_USER_LOGOUT => 'parametersForLogout',
        self::EVENT_USER_COMMENT => 'parametersForComment',
        self::EVENT_USER_LIKE => 'parametersForLike',
    ];

    public static function log($type, $targetObject = null)
    {
        //get parameters from target object

        //save log entry

        //TODO make validation of parameters

        $handler = self::$eventTypeArgumentHandler[$type];

        $newLogEntry = new UserActivityLogEntry([
            'type' => $type,
            'time' => new \DateTime(),
            'user_id' => Auth::id(),
            'parameters' => self::$handler($targetObject)
        ]);

        $newLogEntry->save();
    }

    public static function searchLogs(Request $request)
    {
        $logsQuery = UserActivityLogEntry::with('user');

        if ($request->has('type') && null !==$request->get('type')){
            $logsQuery->where('type', '=', $request->get('type'));
        }

        if ($request->has('user') && null !==$request->get('user')){
            $logsQuery->where('user_id', '=', $request->get('user'));
        }

        if($request->has('sort') && null !==$request->get('sort')){
            $logsQuery->orderBy($request->get('sort'));
        } else{
            $logsQuery->orderBy('time', 'desc');
        }

        return $logsQuery;
    }

    public static function getEventTypes()
    {
        return [
            self::EVENT_USER_LOGIN,
            self::EVENT_USER_LOGOUT,
            self::EVENT_USER_COMMENT,
            self::EVENT_USER_LIKE
        ];
    }

    private static function parametersForLogin()
    {
        return null;
    }

    private static function parametersForLogout()
    {
        return null;
    }

    private static function parametersForComment(Comment $comment)
    {
        $routeConfig = $comment->getCommentContainer()->getRouteConfig();
        $title = $comment->getCommentContainer()->getTitle();

        $link = route($routeConfig[0], $routeConfig[1]);

        return [
            'description' => 'Комментарий для <a target="_blank" href="'.$link.'">'.($title ? : $link) .'</a>'
        ];
    }

    private static function parametersForLike(UserReputation $like)
    {
        return [
            'user_id' => $like->recipient_id,
            'comment_id' => $like->comment->id,
//            'topic_id' => $like->comment->topic->id,
//            'topic_title' => $like->comment->topic->title,
        ];
    }
}
