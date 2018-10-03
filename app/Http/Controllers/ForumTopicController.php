<?php

namespace App\Http\Controllers;

use App\CensorshipWord;
use App\File;
use App\ForumSection;
use App\ForumTopic;
use App\Http\Requests\ForumTopicRebaseRequest;
use App\Http\Requests\ForumTopicStoreRequest;
use App\Http\Requests\ForumTopicUpdteRequest;
use App\User;
use foo\bar;
use Illuminate\Http\Request;
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
        $topic = ForumTopic::where('id', $id)->with(User::getUserWithReputationQuery())
            ->withCount('comments', 'positive','negative')->first();

        if(!$topic){
            return abort(404);
        }

        $comments = $topic->comments()->with(User::getUserWithReputationQuery())
            ->orderBy('created_at')->paginate(20);

        ForumTopic::where('id', $id)->update(['reviews' => $topic->reviews+1]);

        return view('forum.topic')->with([
                'topic' => $topic->load('section'),
                'comments' => $comments
            ]);
    }

    /**
     * Display form for create new topic
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if($request->has('section_id')){
            return view('forum.create_topic')->with('section', ForumSection::find($request->get('section_id')));
        }

        return back();
    }

    /**
     * Save new topic and redirect to it
     *
     * @param ForumTopicStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ForumTopicStoreRequest $request)
    {
        $topic_data = $request->validated();

        $topic_data['user_id'] = Auth::id();

        if ($request->file('preview_img')){
            $path = str_replace('public', '/storage',$request->file('preview_img')->store('public/preview_img'));

            $file = File::create([
                'user_id' => Auth::id(),
                'title' => 'Превью '.$request->get('title'),
                'link' => $path
            ]);

            unset($topic_data['preview_img']);

            $topic_data['preview_file_id'] = $file->id;
        }

        $topic_data = self::checkTopicData($topic_data);

        $topic = ForumTopic::create($topic_data);

        return redirect()->route('forum.topic.index', ['id' => $topic->id]);
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

        ForumTopic::where('id', $id)->update(['section_id' => $request->get('section_id')]);

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
        $topic = ForumTopic::where('id', $id)->withCount('comments', 'positive','negative')->first();

        if(!$topic){
            return abort(404);
        }

        return view('forum.edit_topic', ['topic' => $topic->load('section'), 'sections' => ForumSection::where('is_active', 1)->get(['id', 'title','name'])]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ForumTopicUpdteRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ForumTopicUpdteRequest $request, $id)
    {
        $topic_data = [
            'title'=> $request->get('title'),
            'content'=> $request->get('content')
        ];

        if ($request->has('preview_content') && $request->get('preview_content') != ''){
            $topic_data['preview_content'] = $request->get('preview_content');
        } else {
            $topic_data['preview_content'] = null;
        }

        if ($request->has('start_on') && $request->get('start_on') != ''){
            $topic_data['start_on'] = $request->get('start_on');
        } else {
            $topic_data['start_on'] = null;
        }

        $topic_data = self::checkTopicData($topic_data);

        ForumTopic::where('id', $id)->update($topic_data);

        return redirect()->route('forum.topic.index', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

        $topic->delete();

        return redirect()->foute('forum.index');
    }

    /**
     * Check text data to censorship words
     *
     * @param array $data
     * @return array
     */
    public static function checkTopicData(array $data)
    {
        if(isset($data['title']) && $data['title']){
            $data['title'] = CensorshipWord::check($data['title']);
        }

        if (isset($data['preview_content']) && $data['preview_content']){
            $data['preview_content'] = CensorshipWord::check($data['preview_content']);
        }

        $data['comment'] = CensorshipWord::check($data['comment']);

        return $data;
    }
}
