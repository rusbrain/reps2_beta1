<?php

namespace App\Http\Controllers;

use App\{ForumTopic, Replay, Services\Forum\TopicService};
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
//            'popular_forum_topics'  => ForumTopic::popularForumTopics(), // TODO: remove
//            'last_news'             => ForumTopic::lastNews(), // TODO: remove
        ]);
    }

    /**
     * @param PortalSearchRequest $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function search(PortalSearchRequest $request)
    {
        switch ($request->get('section')){
            case 'news':
                return redirect()->route('news', $request->all());
                break;
            case 'forum':
                return redirect()->route('forum.topic.search', $request->all());
                break;
            case 'replay':
                return redirect()->route('replay', $request->all());
                break;
        }
        return back();
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function lastNews()
    {
        return view('home.last_news')->with(['last_news' => ForumTopic::lastNews()]);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function lastForums()
    {
        return view('home.last_forums')->with(['last_forum' => TopicService::getLastForumHome()]);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function topForums()
    {
        return view('home.top_forums')->with(['popular_forum_topics' => ForumTopic::popularForumTopics()]);
    }
}