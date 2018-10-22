<?php

namespace App\Http\Controllers\Admin;

use App\ForumSection;
use App\Http\Requests\ForumSectionUpdateAdminRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumController extends Controller
{
    /**
     * Get forum sections list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = ForumSection::withCount('topics')->orderBy('position')->paginate(20);

        return view('admin.forum.section.list')->with(['data' => $data]);
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

        $section = ForumSection::find($section_id);

        foreach ($section->topics()->get() as $topic){
            $topic->comments()->delete();
            $topic->positive()->delete();
            $topic->negative()->delete();
        }

        $section->topics()->delete();

        ForumSection::where('id', $section_id)->delete();

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
    public function saveTopic(ForumSectionUpdateAdminRequest $request, $section_id)
    {
        $data = $request->validated();

        $data['is_active']              = $data['is_active']??0;
        $data['is_general']             = $data['is_general']??0;
        $data['user_can_add_topics']    = $data['user_can_add_topics']??0;

        ForumSection::where('id',$section_id)->update($data);

        return back();
    }

    /**
     * Create new forum section
     *
     * @param ForumSectionUpdateAdminRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createTopic(ForumSectionUpdateAdminRequest $request)
    {
        $section = ForumSection::create($request->validated());

        return redirect()->route('admin.forum.section.edit', ['id' => $section->id]);
    }
}