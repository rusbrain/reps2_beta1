<?php

namespace App\Http\Controllers;

use App\{
    ForumTopic, Replay, UserGallery
};
use App\Http\Requests\PortalSearchRequest;
use Illuminate\Database\Eloquent\Builder;

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

    const REPLAYS = 'replay';
    const GALLERIES = 'gallery';
    const FORUMS = 'forum';

    public static $records_type = [
        self::REPLAYS => [],
        self::GALLERIES => [],
        self::FORUMS => [],
    ];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * @param PortalSearchRequest $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function search(PortalSearchRequest $request)
    {
        switch ($request->get('section')) {
            case 'news':
                return redirect()->route('news', $request->all());
                break;
            case 'forum':
                return redirect()->route('forum.topic.search', $request->all());
                break;
            case 'replay':
                return redirect()->route('replay.search', $request->all());
                break;
        }
        return back();
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function lastForums()
    {
        return view('home.last_forums')->with(['news' => ForumTopic::getLastForums()]);
    }
}

