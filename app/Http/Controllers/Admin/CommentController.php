<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Services\Base\BaseDataService;
use App\Services\Base\ViewService;
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
        $comments   = Comment::getComment($object_name, $id);
        return BaseDataService::getPaginationData(ViewService::getComments($comments), ViewService::getPagination($comments));
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
