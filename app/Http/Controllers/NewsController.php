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
        $request_data = $request->validated();
        foreach ($request_data as $key=>$datum){
            if (is_null($datum)){
                unset($request_data[$key]);
            }
        }
        $str = '';
        foreach ($request_data as $key => $datum) {
            $str .= '&'.$key.'='.$datum;
        }

        return view('news.index')->with([
            'request' => $str,
            'search_text' => $request->get('text'),
            'search_section' => HomeController::SEARCH_NEWS,
        ]);
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
