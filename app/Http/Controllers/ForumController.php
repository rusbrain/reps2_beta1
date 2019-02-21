<?php

namespace App\Http\Controllers;

use App\{ForumSection, ForumTopic, Services\Base\UserViewService};
use App\Services\Forum\SectionService;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function section($name)
    {
        $data = ForumSection::getSectionByName($name);
        $topics = ForumSection::getSectionTopicsByName($name); //TODO: remove
        return view('forum.section')->with(SectionService::getSectionViewData($topics, $data->title));
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
}
