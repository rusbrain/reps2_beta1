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
    public function index(){
        $user = Auth::user();
        return view('comments.my_comments')->with(['user' => $user, 'comments_count' => $user->comments()->count()]);
    }

    /**
     * @return array
     */
    public function pagination()
    {
        $comments = $this->paginationData(Auth::id());
        return ['comments' => UserViewService::getUserComments($comments), 'pagination' => UserViewService::getPagination($comments)];
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function paginationData($id)
    {
        $user = User::find($id);
        return $user->comments()->orderBy('created_at', 'desc')->with('user', 'topic', 'replay', 'gallery')->paginate(20);
    }
}
