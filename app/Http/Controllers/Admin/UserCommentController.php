<?php

namespace App\Http\Controllers\Admin;

use App\{Comment, Http\Controllers\UsersCommentController, User};
use App\Services\Base\{BaseDataService, AdminViewService};

class UserCommentController extends UsersCommentController
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
        $comments = $this->paginationData($id);
        return BaseDataService::getPaginationData(AdminViewService::getUserComment($comments), AdminViewService::getPagination($comments));
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
