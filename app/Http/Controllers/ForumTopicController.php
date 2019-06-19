<?php

namespace App\Http\Controllers;

use App\{ Comment, ForumSection, ForumTopic, Services\Base\UserViewService, Services\User\UserService, User };
use App\Http\Requests\{ForumTopicRebaseRequest, ForumTopicStoreRequest,ForumTopicUploadRequest, ForumTopicUpdateRequest};
use App\Services\Forum\TopicService;
use Illuminate\Support\Facades\Auth;

class ForumTopicController extends Controller
{
    /**
     * Display topic page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index($id)
    {
        $topic = ForumTopic::getTopicWithRelations($id);
        if(!$topic){
            return abort(404);
        }
        $comments = Comment::getObjectComments($topic);

        TopicService::updateReview($topic);

        return view('forum.topic')->with([
                'topic' => $topic->load('section'),
                'comments' => $comments
            ]);
    }

    /**
     * Display form for create new topic
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {
        return view('forum.create_topic')->with('sections', ForumSection::all());
    }

    /**
     * Save new topic and redirect to it
     *
     * @param ForumTopicStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ForumTopicStoreRequest $request)
    {
        return redirect()->route('forum.topic.index', ['id' => TopicService::storeTopic($request)]);
    }

    /**
     * Rebase topic to other section
     *
     * @param ForumTopicRebaseRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rebase(ForumTopicRebaseRequest $request, $id)
    {
        $topic = ForumTopic::find($id);

        if (!$topic){
            return abort(404);
        }

        if ($topic->user_id != Auth::id()){
            return abort(403);
        }

        TopicService::rebaseTopic($request->get('section_id'), $id);
        return redirect()->route('forum.topic.index', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /**@var ForumTopic $topic*/
        $topic = ForumTopic::where('id', $id)->with('icon')->first();

        if(!$topic){
            return abort(404);
        }

        if(!($topic->user_id == Auth::user()->id && TopicService::checkForumEdit($topic)) && !UserService::isAdmin() && !UserService::isModerator()){
            return redirect()->route('error',['id' => 'Данный топик закрыт для редактирования']);
        }

        return view('forum.edit_topic', [
            'topic'     => $topic->load('section'),
            'sections'  => ForumSection::where('is_active', 1)->get(['id', 'title','name'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ForumTopicUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ForumTopicUpdateRequest $request, $id)
    {
        $topic = ForumTopic::find($id);
        if (!$topic){
            return abort(404);
        }

        TopicService::update($request, $topic);
        return redirect()->route('forum.topic.index', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $topic = ForumTopic::find($id);

        if (!$topic){
            return abort(404);
        }

        if ($topic->user_id != Auth::id()){
            return abort(403);
        }

        TopicService::remove($topic);

        return redirect()->route('forum.index');
    }

    /**+
     * @param int $user_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getUserTopic($user_id = 0)
    {
        if ($user_id == 0){
            $user_id = Auth::id();
        }

        $data = ForumSection::getUserTopics($user_id);//TODO: remove
        return view('forum.my_topics')->with([
            'topics' => $data, //TODO: remove
            'user_id' => $user_id]);
    }

    /**
     * @param $user_id
     * @return array
     */
    public function userTopicPagination($user_id)
    {
        $data = ForumSection::getUserTopics($user_id);
        return ['topics' => UserViewService::getTopics($data), 'pagination' => UserViewService::getPagination($data)];
    }

    /**
     * @param $request : file
     * @return file_path
     */
    public function img_upload(Request $request) {
        if($request->hasFile('file')) {
            $allowedExt = ['jpg', 'png', 'gif'];
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $extCheck = in_array($ext, $allowedExt);

            if($extCheck) {
                $filename = uniqid().'.'.$ext;
                $dir_name = "forum";
                try {
                    Storage::putFileAs("public/forum", $file, $filename, 'public');
                    $path = "forum/" . $filename;
                    $url = Storage::url($path);
                    $result = array (
                        'success' => true,
                        'data' => $url
                    );
                    return $result;
                } catch (\Exception $e) {
                    return array (
                        'success' => false,
                        'data' => 'Upload Error'
                    );
                }

            } else {
                return array (
                    'success' => false,
                    'data' => 'File Type error'
                );
            }
        }
    }
}
