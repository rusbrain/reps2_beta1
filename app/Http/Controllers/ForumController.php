<?php

namespace App\Http\Controllers;

use App\ForumSection;
use App\ForumTopic;
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

        if (!$data){
            return abort(404);
        }

        $topics = ForumTopic::getTopicsForSection($data);

        return view('forum.section')->with(SectionService::getSectionViewData($topics, $data->title));
    }
}
