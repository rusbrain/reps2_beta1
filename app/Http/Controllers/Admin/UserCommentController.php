<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Services\Base\BaseDataService;
use App\Services\Base\ViewService;
use App\User;
use App\Http\Controllers\Controller;

class UserCommentController extends Controller
{
    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index($id){
        $user = User::find($id);
        return view('admin.user.comments.list')->with(['user' => $user, 'comments_count' => $user->comments()->count()]);
    }

    /**
     * @param $id
     * @return array
     */
    public function pagination($id)
    {
        $user = User::find($id);
        $comments = $user->comments()->orderBy('created_at', 'desc')->with('user', 'topic', 'replay', 'gallery')->paginate(20);
        return BaseDataService::getPaginationData(ViewService::getUserComment($comments), ViewService::getPagination($comments));
    }

    /**
     * @param $user_id
     * @param $comments_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($user_id, $comments_id)
    {
        Comment::where('id', $comments_id)->delete();
        return back();
    }
}
