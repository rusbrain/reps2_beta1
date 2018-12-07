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
    const SEARCH_REPLAY = 'replay';
    const SEARCH_NEWS = 'news';
    const SEARCH_FORUM = 'forum';

    public static $search_types = [
        self::SEARCH_FORUM => 'Форум',
        self::SEARCH_REPLAY => 'Реплеи',
        self::SEARCH_NEWS => 'Новости'
    ];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popular_forum_topics = ForumTopic::where('approved',1)
            ->where(function ($q){
                $q->whereNull('start_on')
                    ->orWhere('start_on','<=', Carbon::now()->format('Y-M-d'));
            })
            ->withCount( 'positive', 'negative', 'comments')
            ->whereHas('section', function ($query){
            $query->where('is_active',1)->where('is_general',1);
                })
            ->with('preview_image')
            ->limit(5)
            ->orderBy('created_at', 'desc')
            ->orderBy('rating', 'desc')->get();

        $last_news = ForumTopic::news()->where('approved',1)->with(['user'=> function($q){
            $q->withTrashed()->with('avatar');
        }])
            ->withCount( 'positive', 'negative', 'comments')
            ->with('preview_image', 'icon')->limit(5)->get();

        return view('home.index')->with([
            'popular_forum_topics'  => $popular_forum_topics,
            'last_news'  => $last_news,
        ]);
    }

    public function search(PortalSearchRequest $request)
    {
        $search = $request->get('search');
        switch ($request->get('section')){
            case 'news':
                $data = ForumTopic::news()->where('approved',1)->with(['user'=> function($q){
                    $q->withTrashed()->with('avatar');
                }])
                    ->withCount( 'positive', 'negative', 'comments')
                    ->where('title', 'like', "%$search%")
                    ->with('preview_image', 'icon')->paginate(20);
                return view('forum.section')->with('topics', $data);
                break;
            case 'forum':
                $data = ForumTopic::with(['user'=> function($q){
                    $q->withTrashed();
                }])
                    ->withCount( 'positive', 'negative', 'comments')
                    ->with('icon')
                    ->where(function ($q){
                        $q->whereNull('start_on')
                            ->orWhere('start_on', '<=', Carbon::now()->format('Y-M-d'));
                    })
                    ->where('title', 'like', "%$search%")
                    ->orderBy('created_at', 'desc')->paginate(20);
                return view('forum.section')->with(['topics'=> $data, 'title' => 'Поиск']);
                break;
            case 'replay':
                $replay = new ReplayController();
                return $replay->getList(Replay::where('title', 'like', "%$search%"));
                break;
        }
    }
}