<?php

namespace App\Http\Controllers;

use App\Comment;
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
        $sections = ForumSection::active()->withCount('topics')->get();
        $section_comments = \DB::select('select ft.section_id, count(*) as comment_count from comments as c left join forum_topics as ft On ft.id = c.object_id where c.relation = ? and ft.section_id > 0 group by ft.section_id', [Comment::RELATION_FORUM_TOPIC]);

        $section_comments_count = [];
        foreach ($section_comments as $comment){
            $section_comments_count[$comment->section_id] = $comment->comment_count;
        }
        foreach ($sections as $key=>$section) {
            $sections[$key]['comment_count'] = $section_comments_count[$section->id];
        }

        return view('forum.forum')->with('sections', $sections);
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
            $q->with('avatar')->withTrashed();
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

        return view('forum.section')->with(['topics'=> $topics, 'title' => $data->title, 'total_comment_count' => $topics->sum('comments_count')]);
    }
}
