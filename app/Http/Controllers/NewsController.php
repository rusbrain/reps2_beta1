<?php

namespace App\Http\Controllers;

use App\ForumTopic;
use App\Http\Requests\SearchForumTopicRequest;
use App\Services\Forum\TopicService;

class NewsController extends Controller
{
    /**
     * @param SearchForumTopicRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(SearchForumTopicRequest $request)
    {
        $news = TopicService::search($request->validated(), ForumTopic::newsWithQuery(ForumTopic::news()));
        return view('news.index')->with('news', $news->paginate(20));
    }
}
