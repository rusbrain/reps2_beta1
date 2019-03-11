<?php

namespace App\Http\Controllers;

use App\{ForumSection, ForumTopic, Services\Base\UserViewService};
use App\Services\Forum\SectionService;
use foo\bar;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Get forum page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('forum.forum')->with('sections', SectionService::getSections());
    }

    /**
     * get forum section page
     *
     * @param $name
     * @return $this
     */
    public function section($name)
    {
        $data = ForumSection::getSectionByName($name);
        $topics = ForumSection::getSectionTopicsByName($name);
        return view('forum.section')->with([
            'total_comment_count' => $topics->sum('comments_count'),
            'data' => $data
        ]);
    }

    /**
     * @param $name
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function sectionPagination($name)
    {
        $topics = ForumSection::getSectionTopicsByName($name);
        return ['topics' => UserViewService::getSection($topics), 'pagination' => UserViewService::getPagination($topics)];
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function searchTopic(Request $request)
    {
        if ($request->has('text')) {
            return view('forum.search_results')->with([
                'search_text' => $request->get('text'),
                'title' => 'Поиск Тем'
            ]);
        }
        return back();
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function searchPaginationTopic(Request $request)
    {
        if ($request->has('text')){
            $topics = ForumTopic::searchTopic($request->get('text'))->paginate(20);
            return ['topics' => UserViewService::getSection($topics), 'pagination' => UserViewService::getPagination($topics)];
        }
        return back();
    }

}

