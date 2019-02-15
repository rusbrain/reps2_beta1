<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 15:52
 */

namespace App\Services\Forum;


use App\File;
use App\ForumTopic;
use App\Http\Requests\ForumTopicStoreRequest;
use App\Http\Requests\ForumTopicUpdteRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicService
{
    /**
     * @param ForumTopic $topic
     */
    public static function updateReview(ForumTopic $topic)
    {
        ForumTopic::where('id', $topic->id)->update(['reviews' => $topic->reviews+1]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public static function savePreview(Request $request)
    {
        $title = 'Превью '.$request->has('title')?$request->get('title'):'';
        $file = File::storeFile($request->file('preview_img'), 'preview_img', $title);

        return $file->id;
    }

    /**
     * @param ForumTopicStoreRequest $request
     * @return mixed
     */
    public static function storeTopic(ForumTopicStoreRequest $request)
    {
        $topic_data = $request->validated();

        $topic_data['user_id'] = Auth::id();
        $topic_data['commented_at'] = Carbon::now();

        if ($request->file('preview_img')){
            unset($topic_data['preview_img']);
            $topic_data['preview_file_id'] = self::savePreview($request);
        }

        $topic = ForumTopic::create($topic_data);

       return $topic->id;
    }

    /**
     * @param $section_id
     * @param $topic_id
     */
    public static function rebaseTopic($section_id, $topic_id)
    {
        ForumTopic::where('id', $topic_id)->update(['section_id' => $section_id]);
    }

    /**
     * @param ForumTopicUpdteRequest $request
     * @param $topic
     */
    public static function update(ForumTopicUpdteRequest $request, $topic)
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

        if ($request->file('preview_img')){
            if ($topic->preview_file_id){
                File::removeFile($topic->preview_file_id);
            }

            $title = 'Превью '.$request->has('title')?$request->get('title'):'';
            $file = File::storeFile($request->file('preview_img'), 'preview_img', $title);

            unset($topic_data['preview_img']);

            $topic_data['preview_file_id'] = $file->id;
        }

        ForumTopic::where('id', $topic->id)->update($topic_data);
    }

    /**
     * @param ForumTopic $topic
     * @throws \Exception
     */
    public static function remove(ForumTopic $topic)
    {
        if ($topic->preview_file_id){
            File::removeFile($topic->preview_file_id);
        }

        $topic->comments()->delete();
        $topic->positive()->delete();
        $topic->negative()->delete();
        $topic->delete();
    }
}