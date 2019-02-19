<?php

namespace App\Http\Controllers;

use App\{ForumTopic, Replay};
use App\Http\Requests\PortalSearchRequest;
use App\Services\Replay\ReplayService;

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
        return view('home.index')->with([
            'popular_forum_topics'  => ForumTopic::popularForumTopics(),
            'last_news'             => ForumTopic::lastNews(),
        ]);
    }

    /**
     * @param PortalSearchRequest $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function search(PortalSearchRequest $request)
    {
        $search = $request->get('search');
        switch ($request->get('section')){
            case 'news':
                return view('forum.section')
                    ->with('topics', ForumTopic::getSearchTitleNews($search));
                break;
            case 'forum':
                return view('forum.section')
                    ->with(['topics'=> ForumTopic::getSearchTitle($search), 'title' => 'Поиск']);
                break;
            case 'replay':
                return ReplayService::getList(Replay::where('title', 'like', "%$search%"), "Поиск реплаев");
                break;
        }
    }
}