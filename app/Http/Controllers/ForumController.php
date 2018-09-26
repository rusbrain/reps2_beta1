<?php

namespace App\Http\Controllers;

use App\ForumSection;
use App\ForumTopic;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Request identification
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $uri = str_replace(".php", "", str_replace("/", "", $request->getPathInfo()));

        if ($uri == 'columns') {
            return $this->getSection('columns');
        }

        if ($uri == 'forum') {
            if ($request->has('forum')){
                return $this->getSectionRepsId($request->get('forum'));
            }

            return $this->getForum();
        }

        if ($request->has('search')){
            return $this->getSection('all');
        }

        if ($request->has('news')){
            return $this->getSection($request->get('news'));
        }
    }

    /**
     * Get section date by name
     *
     * @param $section_name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function getSection($section_name)
    {
        if($section_name = 'all'){
            $data = ForumTopic::whereHas('section', function ($query){
                $query->where('in_menu', 1);
            });
        } else {
            $data = ForumTopic::whereHas('section', function ($query) use ($section_name){
                $query->where('name', $section_name);
            });
        }

        $data->with('user')->withCount(['comments', 'positive', 'negative'])->orderBy('created_at','desc')->paginate(20);

        return view('forum.section')->with('topics', $data);
    }

    /**
     * Get forum data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function getForum()
    {
        $data = ForumSection::with(['topics' => function($query){
            $query->with('user')->orderBy('created_at', 'desc')->withCount(['positive', 'negative'])->limit(5);
        }])->withCount('topics')->orderBy('position')->get();

        return view('forum.forum')->with('sections', $data);
    }

    /**
     * Get section date by reps id
     *
     * @param $section_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function getSectionRepsId($section_id)
    {
        $data = ForumTopic::whereHas('section', function ($query) use($section_id){
            $query->where('reps_id', $section_id);
        })
            ->withCount(['comments', 'positive', 'negative'])
            ->with('user')
            ->orderBy('created_at','desc')
            ->paginate(20);

        return view('forum.section')->with('topics', $data);
    }
}
