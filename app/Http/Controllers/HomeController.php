<?php

namespace App\Http\Controllers;

use App\ForumSection;
use Illuminate\Http\Request;
use App\Replay;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $general_gorum = ForumSection::general_active()->get();
        $last_forum = ForumSection::general_active()->with(['topics' =>function($query){
            $query->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5);
        }]);

        $last_gosu_replay = Replay::gosuReplay()->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5);
        $last_user_replay = Replay::userReplay()->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5);
        return view('home.index')->with([
            'forum_menu'        => $general_gorum,
            'last_forum'        =>$last_forum,
            'last_gosu_replay'  =>$last_gosu_replay,
            'last_user_replay'  => $last_user_replay,
        ]);

    }
}
