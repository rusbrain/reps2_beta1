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
        $data = ForumSection::active()->with(['topics' => function($query){
            $query->with(['user'=> function($q){
                $q->withTrashed();
            }])->orderBy('created_at', 'desc')->withCount(['positive', 'negative'])->limit(5);
        }])->withCount('topics')->get();

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
        $data = ForumSection::active()->where('name', $name)->first();

        if (!$data){
            return abort(404);
        }

        $data->topics = $data->topics()->with(['user'=> function($q){
            $q->withTrashed();
        }])->with(['comments' => function($query){
                $query->orderBy('created_at', 'desc')->first();
            }])
            ->withCount(['positive', 'negative', 'comments'])
            ->orderBy('created_at', 'desc')->paginate(20);

        return view('forum.section')->with('topics', $data);
    }
}
