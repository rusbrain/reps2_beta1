<?php

namespace App\Http\Controllers\Admin;

use App\ForumTopic;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.user_list');
    }

    /**
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUsersTopics($user_id)
    {
        $user = User::find($user_id);

        $topics  = $user->topics()->with('section')->with(['user'=> function($q){
            $q->withTrashed();
        }])->withCount('comments', 'positive', 'negative')->paginate(50);

        return view('admin.topics')->with(['topics' => $topics, 'title' => "Темы форума $user->name", 'user' => $user]);
    }
}
