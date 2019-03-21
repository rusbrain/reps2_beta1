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
    public function lastNews()
    {
        return view('home.last_news')->with(['last_news' => ForumTopic::lastNews()]);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function lastForums()
    {
        $last_records = $this->getRecordsById($this->lastFiveRecords());
        return view('home.last_forums')->with(['last_forum' => $last_records]);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function topForums()
    {
        return view('home.top_forums')->with(['popular_forum_topics' => ForumTopic::popularForumTopics()]);
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function getRecordsById($ids)
    {
        /**create ids arrays by record type*/
        foreach ($ids as $id) {
            foreach (self::$records_type as $type => $i) {
                if ($id->type == $type) {
                    self::$records_type[$type][] = $id->id;
                }
            }
        }
        $last_records['replays'] = Replay::getReplayByIds(self::$records_type[self::REPLAYS]);
        $last_records['galleries'] = UserGallery::getGalleriesByIds(self::$records_type[self::GALLERIES]);
        $last_records['forums'] = ForumTopic::getForumTopicsByIds(self::$records_type[self::FORUMS]);

        return $last_records;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function lastFiveRecords()
    {
        /**@var Builder $forums */
        $forums = ForumTopic::getLastForumTopic(5);
        $replays = Replay::getLastReplays(5);
        $galleries = UserGallery::getLastGallery(5);

        return $forums->union($replays)
            ->union($galleries)->orderBy('created_at', 'desc')
            ->limit(5)->get();
    }

}

