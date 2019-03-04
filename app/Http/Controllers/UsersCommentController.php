<?php

namespace App\Http\Controllers;

use App\Services\Base\BaseDataService;
use App\Services\Base\UserViewService;
use App\User;
use Illuminate\Support\Facades\Auth;

class UsersCommentController extends Controller
{
    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index()
    {
        $user = Auth::user();
        return view('user.comments.my_comments')->with([
            'user' => $user,
            'comments_count' => $user->comments()->count(),
        ]);
    }

    /**
     * @return array
     */
    public function pagination()
    {
        $comments = $this->paginationData(Auth::id());
        return ['comments' => UserViewService::getUserComments($comments)];
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function paginationData($id)
    {
        $user = User::find($id);
        $comments = $user->comments()->orderBy('created_at', 'desc')->with('user', 'topic', 'replay', 'gallery')->get();
        return $this->createCommentDataArray($comments);
    }

    public function createCommentDataArray($comments)
    {
        $types = [
            'topic' =>
                [
                    'title' => 'Форумы',
                    'relation' => 'topic',
                    'route' => 'forum.topic.index',
                    'comments' => []
                ],
            'gallery' =>
                [
                    'title' => 'Галереи',
                    'relation' => 'gallery',
                    'route' => 'gallery.view',
                    'comments' => []
                ],
            'replay' =>
                [
                    'title' => 'Реплеи',
                    'relation' => 'replay',
                    'route' => 'replay.get',
                    'comments' => []
                ]
        ];

        if (!$comments) {
            return false;
        }
        foreach ($comments as $item => $comment) {
            foreach ($types as $key => $type) {
                if ($comment->$key) {
                    $types[$key]['comments'][] = $comment;
                }
            }
        }
        return $types;
    }
}
