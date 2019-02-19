<?php

namespace App\Http\Controllers\Admin;

use App\{ForumSection, ForumTopic};
use App\Http\Requests\{AdminTopicCreateRequest, ForumTopicUpdateAdminRequest, SearchForumTopicRequest};
use App\Services\Base\{BaseDataService, AdminViewService};
use App\Services\Forum\TopicService;
use App\Http\Controllers\Controller;

class ForumTopicController extends Controller
{
    /**
     * Get Forum topic list
     *
     * @param SearchForumTopicRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function topics(SearchForumTopicRequest $request)
    {
        $data = TopicService::search($request->validated())->count();
        return view('admin.forum.topic.list')->with(['topics_count' => $data, 'request_data' => $request->validated(), 'sections' => ForumSection::all()]);
    }

    /**
     * @param SearchForumTopicRequest $request
     * @return array
     */
    public function pagination(SearchForumTopicRequest $request)
    {
        $data = ForumTopic::getTopicPagination($request);
        return BaseDataService::getPaginationData(AdminViewService::getTopics($data), AdminViewService::getPagination($data));
    }

    /**
     * Get Forum Topics by user
     *
     * @param SearchForumTopicRequest $request
     * @param $user_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getUsersTopics(SearchForumTopicRequest $request, $user_id)
    {
        return view('admin.forum.topic.list')->with(TopicService::getUserTopic($request, $user_id));
    }

    /**
     * Approve Forum Topic
     *
     * @param $topic_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($topic_id)
    {
        ForumTopic::where('id', $topic_id)->update(['approved' => 1]);
        return back();
    }

    /**
     * Disable Forum Topic
     *
     * @param $topic_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unApprove($topic_id)
    {
        ForumTopic::where('id', $topic_id)->update(['approved' => 0]);
        return back();
    }

    /**
     * Delete Forum Topic
     *
     * @param $topic_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove($topic_id)
    {
        TopicService::remove(ForumTopic::find($topic_id));
        return back();
    }

    /**
     * Get Forum Topic
     *
     * @param $topic_id
     * @return mixed
     */
    public function getTopic($topic_id)
    {
        return view('admin.forum.topic.view')->with('topic', ForumTopic::getTopicById( $topic_id));
    }

    /**
     * Get view with form for edit forum topic
     *
     * @param $topic_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTopicEdit($topic_id)
    {
        return view('admin.forum.topic.edit')->with(['topic' => ForumTopic::getTopicById( $topic_id), 'sections' => ForumSection::all()]);
    }

    /**
     * Save updates of forum topic
     *
     * @param ForumTopicUpdateAdminRequest $request
     * @param $topic_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function saveTopic(ForumTopicUpdateAdminRequest $request, $topic_id)
    {
        TopicService::update($request, ForumTopic::find($topic_id), true);
        return back();
    }

    /**
     * Forum Topic as news
     *
     * @param $topic_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function news($topic_id)
    {
        ForumTopic::where('id', $topic_id)->update(['news' => 1]);
        return back();
    }

    /**
     * Forum topic as not news
     *
     * @param $topic_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notNews($topic_id)
    {
        ForumTopic::where('id', $topic_id)->update(['news' => 0]);
        return back();
    }

    /**
     * Get view with form for create forum section
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTopicAdd()
    {
        return view('admin.forum.topic.add')->with('sections', ForumSection::all());
    }

    /**
     * Create new forum section
     *
     * @param AdminTopicCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createTopic(AdminTopicCreateRequest $request)
    {
        return redirect()->route('admin.forum.topic.edit', ['id' => TopicService::storeTopic($request, true)]);
    }
}
