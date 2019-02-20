<?php

namespace App\Http\Controllers;

use App\ForumTopic;
use App\Http\Requests\SearchForumTopicRequest;
use App\Services\Base\UserViewService;
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

    /**
     * @param SearchForumTopicRequest $request
     * @return array
     */
    public function pagination(SearchForumTopicRequest $request)
    {
        $request_data = $request->validated();
        $news = TopicService::search($request_data, ForumTopic::newsWithQuery(ForumTopic::news()))->paginate(20);
        return ['news' => UserViewService::getNews($news), 'pagination' => UserViewService::getPagination($news), 'request_data' => $request_data];
    }
}
