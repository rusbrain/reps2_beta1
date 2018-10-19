<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\ForumSection;
use App\ForumTopic;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Requests\ForumTopicUpdateAdminRequest;
use App\Http\Requests\SearchForumTopicRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\File;

class ForumController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.user_list');
    }

    /**
     * Get Forum topic list
     *
     * @param SearchForumTopicRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function topics(SearchForumTopicRequest $request)
    {
        $data = ForumTopic::search(ForumTopic::with('user', 'section')->withCount('negative','positive','comments'), $request->validated())->paginate(50);

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
        }])->withCount('comments', 'positive', 'negative')->paginate(50);

        return view('admin.topics')->with(['topics' => $topics, 'title' => "Темы форума $user->name", 'user' => $user]);
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
     * @param CommentUpdateRequest $request
     * @param $topic_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendComment(CommentUpdateRequest $request, $topic_id)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['relation'] = Comment::RELATION_FORUM_TOPIC;
        $data['object_id'] = $topic_id;

        Comment::create($data);

        return back();
    }

    /**
     * @param $comment_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function commentRemove($comment_id)
    {
        Comment::where('id', $comment_id)->delete();

        return back();
    }

    /**
     * @param $topic_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTopicEdit($topic_id)
    {
        return view('admin.forum.topic.edit')->with(['topic' => ForumTopic::getTopicById( $topic_id), 'sections' => ForumSection::all()]);
    }

    /**
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
}