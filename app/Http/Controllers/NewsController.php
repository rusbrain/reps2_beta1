<?php

namespace App\Http\Controllers;

use App\ForumTopic;
use App\Http\Requests\SearchForumTopicRequest;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @param SearchForumTopicRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(SearchForumTopicRequest $request)
    {
        $news = ForumTopic::news()
            ->with('section', 'preview_image', 'icon')
            ->withCount( 'positive', 'negative', 'comments')
            ->with(['user'=> function($q){
                $q->withTrashed();
            }]);

        $news = ForumTopic::search($news, $request->validated());

        return view('news.index')->with('news', $news->paginate(20));
    }
}
