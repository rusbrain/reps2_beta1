<?php

namespace App\Http\Controllers;

use App\ForumSection;
use App\ForumTopic;
use Carbon\Carbon;
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
            }])->withCount( 'positive', 'negative', 'comments')
                ->orderBy('created_at', 'desc')->limit(5);
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

        $topics = $data->topics()->with(['user'=> function($q){
            $q->withTrashed();
        }])
            ->withCount( 'positive', 'negative', 'comments')
            ->where(function ($q){
                $q->whereNull('start_on')
                    ->orWhere('start_on','<=', Carbon::now()->format('Y-M-d'));
            })
            ->with(['comments' => function($query){
                $query->withCount('positive', 'negative')->orderBy('created_at', 'desc')->get();
            }])
            ->with('comments', 'icon')
            ->orderBy('created_at', 'desc')->paginate(20);

        return view('forum.section')->with(['topics'=> $topics, 'title' => $data->title]);
    }
}
