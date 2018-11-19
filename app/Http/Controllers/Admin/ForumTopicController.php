<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\ForumSection;
use App\ForumTopic;
use App\Http\Requests\ForumTopicUpdateAdminRequest;
use App\Http\Requests\SearchForumTopicRequest;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $data = ForumTopic::search(ForumTopic::with('user', 'section', 'icon'), $request->validated())->where(function ($q){
            $q->whereNull('start_on')
                ->orWhere('start_on', Carbon::now()->format('Y-M-d'));
        })->paginate(50);

        return view('admin.forum.topic.list')->with(['data' => $data, 'request_data' => $request->validated(), 'sections' => ForumSection::all()]);
    }

    /**
     * Get Forum Topics by user
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUsersTopics($user_id)
    {
        $user = User::find($user_id);

        $topics  = $user->topics()->with('section')->with(['user'=> function($q){
            $q->withTrashed();
        }])->paginate(50);

        return view('admin.topics')->with(['topics' => $topics, 'title' => "Темы форума $user->name", 'user' => $user]);
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
     */
    public function remove($topic_id)
    {
        $topic = ForumTopic::find($topic_id);

        $topic->comments()->delete();
        $topic->positive()->delete();
        $topic->negative()->delete();

        ForumTopic::where('id', $topic_id)->delete();

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
        $topic = ForumTopic::find($topic_id);
        $data = $request->validated();

        $data['approved']   = $data['approved']??0;
        $data['news']       = $data['news']??0;

        if($request->file('preview_img')){
            if ($request->file('preview_img')){
                if ($topic->preview_file_id){
                    File::removeFile($topic->preview_file_id);
                }

                $title = 'Превью '.$request->has('title')?$request->get('title'):'';
                $file = File::storeFile($request->file('preview_img'), 'preview_img', $title);

                $data['preview_file_id'] = $file->id;
            }
        }

        unset($data['preview_img']);
        ForumTopic::where('id',$topic_id)->update($data);

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
     * @param ForumTopicUpdateAdminRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createTopic(ForumTopicUpdateAdminRequest $request)
    {
        $data = $request->validated();

        if($request->file('preview_img')){
                $title = 'Превью '.$request->has('title')?$request->get('title'):'';
                $file = File::storeFile($request->file('preview_img'), 'preview_img', $title);

                $data['preview_file_id'] = $file->id;
        }

        $data['user_id'] = Auth::id();
        $data['approved']   = $data['approved']??0;
        $data['news']       = $data['news']??0;

        unset($data['preview_img']);

        $topic = ForumTopic::create($data);

        return redirect()->route('admin.forum.topic.edit', ['id' => $topic->id]);
    }
}
