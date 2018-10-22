<?php

namespace App\Http\Controllers;

use App\ForumSection;
use App\ForumTopic;
use App\Http\Requests\PortalSearchRequest;
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

        $forum_topic_query = ForumTopic::where('approved',1)
            ->where(function ($q){
                $q->whereNull('start_on')
                    ->orWhere('start_on', Carbon::now()->format('Y-M-d'));
            })
            ->whereHas('section', function ($query){
            $query->where('is_active',1)->where('is_general',1);
                })
            ->has('preview_image')
            ->with(['user'=> function($q){
                $q->withTrashed()->with('country', 'avatar');
            }])
            ->with('preview_image')
            ->withCount('comments', 'positive', 'negative')
            ->limit(5);

        $new_forum_topics = ForumTopic::news()->limit(5)->get();
        $popular_forum_topics = $forum_topic_query
            ->where('created_at', '<=', Carbon::now()->addMonth(-1)->startOfDay())
            ->orderBy('rating', 'desc')->get();

        return view('home.index')->with([
            'forum_menu'            => $general_gorum,
            'popular_forum_topics'  => $popular_forum_topics,
            'new_forum_topics'      => $new_forum_topics
        ]);
    }

    public function search(PortalSearchRequest $request)
    {
        $search = $request->get('search');
        switch ($request->get('section')){
            case 'news':
                $data = ForumTopic::news()->where('approved',1)->with(['user'=> function($q){
                    $q->withTrashed()->with('country', 'avatar');
                }])
                    ->where('title', 'like', "%$search%")
                    ->with('preview_image')
                    ->withCount('comments', 'positive', 'negative')->paginate(20);
                return view('forum.section')->with('topics', $data);
                break;
            case 'forum':
                $data = ForumTopic::with(['user'=> function($q){
                    $q->withTrashed();
                }])
                    ->where(function ($q){
                        $q->whereNull('start_on')
                            ->orWhere('start_on', Carbon::now()->format('Y-M-d'));
                    })
                    ->withCount(['positive', 'negative', 'comments'])
                    ->where('title', 'like', "%$search%")
                    ->orderBy('created_at', 'desc')->paginate(20);
                return view('forum.section')->with('topics', $data);
                break;
            case 'replay':
                $replay = new ReplayController();
                return $replay->getList(Replay::where('title', 'like', "%$search%"));
                break;
        }
    }
}
