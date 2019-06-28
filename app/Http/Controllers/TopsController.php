<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    User, ForumTopic, Replay
};
use Illuminate\Support\Facades\DB;

class TopsController extends Controller
{
    /**
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('tops.index')->with('tops_users', $this->getTopAllUsers());
    }
    
    /**
     * get top 100 users
     */
    public function getTopAllUsers()
    {
        $top_pts_users      = User::where('is_ban', 0)->with('avatar')->orderBy('points', 'desc')->limit(100)->get();
        $top_rating_users   = User::where('is_ban', 0)->with('avatar')->orderBy('rating', 'desc')->limit(100)->get();
        $top_newspost_users = User::where('is_ban', 0)
            ->with('avatar')
            ->withCount('newstopics')->orderBy('newstopics_count','desc')
            ->limit(100)->get();
        $top_replayspost_users =User::where('is_ban', 0)
            ->with('avatar')
            ->withCount('replays')->orderBy('replays_count','desc')
            ->limit(100)->get();
        return [
            'points'          =>$top_pts_users,
            'rating'          =>$top_rating_users,
            'newstopics_count'=>$top_newspost_users,
            'replays_count'   =>$top_replayspost_users
        ];
    }
}
