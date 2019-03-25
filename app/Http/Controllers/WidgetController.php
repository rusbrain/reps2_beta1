<?php

namespace App\Http\Controllers;

use App\Services\Forum\SectionService;
use App\Services\Replay\ReplayService;

class WidgetController extends Controller
{
    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function allForumSections()
    {
        return view('sidebar-widgets.all-forum-sections')->with(['forum_sections' => SectionService::getAllSections()]);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function generalForumSections()
    {
        return view('sidebar-widgets.general-forum-sections')->with(['general_forum_sections' => SectionService::getGeneralSectionsForum()]);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function gosuReplay()
    {
        return view('sidebar-widgets.gosu-replay')->with(['replays' => ReplayService::getLastGosuReplay()]);
    }
}
