<?php

namespace App\Http\Controllers;

use App\ForumSection;
use App\ForumTopic;
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
        $data = ForumSection::with(['topics' => function($query){
            $query->with('user')->orderBy('created_at', 'desc')->withCount(['positive', 'negative'])->limit(5);
        }])->withCount('topics')->orderBy('position')->get();

        return view('forum.forum')->with('sections', $data);
    }

    /**
     * get forum section page
     *
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function section($name)
    {
        $data = ForumSection::where('name', $name)->first()
            ->topics()->with('user:id,name')->with(['comments' => function($query){
                $query->orderBy('created_at', 'desc')->first();
            }])
            ->withCount(['positive', 'negative', 'comments'])
            ->orderBy('created_at', 'desc')->paginate(20);

        return view('forum.section')->with('topics', $data);
    }
}
