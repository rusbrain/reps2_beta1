<?php

namespace App\Http\Controllers;

use App\ForumSection;
use App\ForumTopic;
use Carbon\Carbon;
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
        $last_forum = ForumSection::active()->with(['topics' =>function($query){
            $query->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5);
        }]);

        $last_gosu_replay = Replay::gosuReplay()->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5)->get();
        $last_user_replay = Replay::userReplay()->withCount('comments', 'positive', 'negative')->with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        $forum_topic_query = ForumTopic::where('approved',1)
            ->whereHas('section', function ($query){
            $query->where('is_active',1)->where('is_general',1);
                })
            ->has('preview_image')->with('user.country', 'user.avatar', 'preview_image')
            ->withCount('comments', 'positive', 'negative')
            ->limit(5);

        $new_forum_topics_q = clone $forum_topic_query;
        $new_forum_topics = $new_forum_topics_q->orderBy('created_at', 'desc')->get();
        $popular_forum_topics = $forum_topic_query
            ->where('created_at', '<=', Carbon::now()->addMonth(-1)->startOfDay())
            ->orderBy('rating', 'desc')->get();

        return view('home.index')->with([
            'forum_menu'            => $general_gorum,
            'last_forum'            =>$last_forum,
            'last_gosu_replay'      =>$last_gosu_replay,
            'last_user_replay'      => $last_user_replay,
            'popular_forum_topics'  => $popular_forum_topics,
            'new_forum_topics'      => $new_forum_topics
        ]);
    }
}
