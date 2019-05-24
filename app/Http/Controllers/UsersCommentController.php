<?php

namespace App\Http\Controllers;

use App\Services\Base\UserViewService;
use App\User;
use Illuminate\Support\Facades\Auth;

class UsersCommentController extends Controller
{
    /**
     * @param int $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($user_id = 0)
    {
        $user = ($user_id == 0) ? Auth::user() : User::find($user_id);
        return view('user.comments.my_comments')->with([
            'user' => $user,
            'comments_count' => $user->comments()->count(),
        ]);
    }

    /**
     * @param int $user_id
     * @return array
     */
    public function pagination($user_id = 0)
    {
        $id = ($user_id == 0) ? Auth::id() : $user_id;
        $comments = $this->paginationData($id);
        return [
            'comments' => UserViewService::getUserComments($comments),
            'pagination' => UserViewService::getPagination($comments)
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function paginationData($id)
    {
        $user = User::find($id);
        $comments = $user->comments()->orderBy('created_at', 'desc')->with('user', 'topic', 'replay',
            'gallery')->paginate(30);
        return $comments;
    }

}
