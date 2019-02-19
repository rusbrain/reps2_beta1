<?php

namespace App\Http\Controllers\Admin;

use App\ForumSection;
use App\Http\Requests\ForumSectionUpdateAdminRequest;
use App\Services\Base\{BaseDataService, AdminViewService};
use App\Http\Controllers\Controller;
use App\Services\Forum\SectionService;

class ForumController extends Controller
{
    /**
     * Get forum sections list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = ForumSection::count();
        return view('admin.forum.section.list')->with(['sections_count' => $data]);
    }

    /**
     * @return array
     */
    public function pagination()
    {
        $data = ForumSection::withCount('topics')->orderBy('position')->paginate(20);
        return BaseDataService::getPaginationData(AdminViewService::getSections($data), AdminViewService::getPagination($data));
    }

    /**
     * Set not active section
     *
     * @param $section_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unactive($section_id)
    {
        ForumSection::where('id', $section_id)->update(['is_active' => 0]);
        return back();
    }

    /**
     * Set active section
     *
     * @param $section_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function active($section_id)
    {
        ForumSection::where('id', $section_id)->update(['is_active' => 1]);
        return back();
    }

    /**
     * Set general section
     *
     * @param $section_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function general($section_id)
    {
        ForumSection::where('id', $section_id)->update(['is_general' => 1]);
        return back();
    }

    /**
     * Set not general section
     *
     * @param $section_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notGeneral($section_id)
    {
        ForumSection::where('id', $section_id)->update(['is_general' => 0]);
        return back();
    }

    /**
     * Set user can add topic to section
     *
     * @param $section_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userCan($section_id)
    {
        ForumSection::where('id', $section_id)->update(['user_can_add_topics' => 1]);
        return back();
    }

    /**
     * Set user can`t add topic to section
     *
     * @param $section_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userNotCan($section_id)
    {
        ForumSection::where('id', $section_id)->update(['user_can_add_topics' => 0]);
        return back();
    }

    /**
     * Delete Forum Section
     *
     * @param $section_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($section_id)
    {
        SectionService::removeSection($section_id);
        return back();
    }

    /**
     * Get view with form for edit forum section
     *
     * @param $section_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSectionEdit($section_id)
    {
        return view('admin.forum.section.edit')->with('section', ForumSection::find( $section_id));
    }

    /**
     * Get view with form for create forum section
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSectionAdd()
    {
        return view('admin.forum.section.add');
    }

    /**
     * Save updates of forum section
     *
     * @param ForumSectionUpdateAdminRequest $request
     * @param $section_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function saveSection(ForumSectionUpdateAdminRequest $request, $section_id)
    {
        SectionService::updateSection($request, $section_id);
        return back();
    }

    /**
     * Create new forum section
     *
     * @param ForumSectionUpdateAdminRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createSection(ForumSectionUpdateAdminRequest $request)
    {
        $section = ForumSection::create($request->validated());
        return redirect()->route('admin.forum.section.edit', ['id' => $section->id]);
    }
}