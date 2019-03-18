<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 15:52
 */

namespace App\Services\Forum;

use App\{File, ForumSection, ForumTopic, User};
use App\Http\Requests\{ForumTopicStoreRequest, ForumTopicUpdteRequest, SearchForumTopicRequest};
use App\Services\Base\FileService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

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
     * @param bool $admin
     * @return mixed
     */
    public static function storeTopic(ForumTopicStoreRequest $request, $admin = false)
    {
        $topic_data = $request->validated();

        $topic_data['user_id'] = Auth::id();
        $topic_data['commented_at'] = Carbon::now();

        if ($request->file('preview_img')){
            unset($topic_data['preview_img']);
            $topic_data['preview_file_id'] = self::savePreview($request);
        }

        if ($admin){
            $data['approved']   = $data['approved']??0;
            $data['news']       = $data['news']??0;
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
     * @param bool $admin
     */
    public static function update(ForumTopicUpdteRequest $request, $topic, $admin = false)
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

        if ($admin){
            $topic_data['approved']   = $data['approved']??0;
            $topic_data['news']       = $data['news']??0;
        }

        if ($request->file('preview_img')){
            if ($topic->preview_file_id){
                FileService::removeFile($topic->preview_file_id);
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
            FileService::removeFile($topic->preview_file_id);
        }

        $topic->comments()->delete();
        $topic->positive()->delete();
        $topic->negative()->delete();
        $topic->delete();
    }

    /**
     * @param SearchForumTopicRequest $request
     * @param $user_id
     * @return array
     */
    public static function getUserTopic(SearchForumTopicRequest $request, $user_id)
    {
        $user = User::find($user_id);
        $topics  = TopicService::search($request->validated(), ForumTopic::where('user_id', $user_id))->count();
        $request_data = $request->validated();
        $request_data['user_id'] = $user_id;

        return [
            'topics_count' => $topics,
            'title' => "Темы форума $user->name",
            'sections' => ForumSection::all(),
            'request_data' => $request_data
        ];
    }

    /**
     * Generate query with search request
     *
     * @param array $data
     * @param bool $query
     * @return bool
     */
    public static function search(array $data, $query = false )
    {
        if (!$query){
            $query = ForumTopic::where('id', '>', 0);
        }

        if (isset($data['user_id']) && null !== $data['user_id']){
            $query->where('user_id', $data['user_id']);
        }

        if (isset($data['min_rating']) && null !== $data['min_rating']){
            $query->where('rating','>=', $data['min_rating']);
        }

        if (isset($data['min_date']) && null !== $data['min_date']){
            $query->where('created_at','>=', $data['min_date']);
        }

        if (isset($data['max_date']) && null !== $data['max_date']){
            $query->where('created_at','<=', $data['max_date']);
        }

        if (isset($data['news']) && null !== $data['news']){
            $query->where('news',$data['news']);
        }

        if (isset($data['approved']) && null !== $data['approved']){
            $query->where('approved',$data['approved']);
        }

        if (isset($data['text']) && null !== $data['text']){
            $query->where(function ($q) use ($data){
                $q->where('title', 'like', "%{$data['text']}%")
                    ->orWhere('preview_content', 'like', "%{$data['text']}%")
                    ->orWhere('content', 'like', "%{$data['text']}%");
            });
        }

        if (isset($data['section_id']) && null !== $data['section_id']){
            $query->whereHas('section', function ($q) use ($data){
                $q->where('id', $data['section_id']);
            });
        }

        if(Input::has('sort') && Input::get('sort')){
            $query->orderBy(Input::get('sort'), 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public static function getLastForumHome()
    {
        return ForumTopic::whereHas('section',
                function ($query) {
                    $query->where('is_active', 1)->where('is_general', 1);
                })
                ->where('approved', 1)
                ->with('preview_image')
                ->withCount('positive', 'negative', 'comments')
                ->limit(5)->get();
    }

    /**
     * @param $topic
     * @return bool
     */
    public static function checkForumEdit($topic)
    {
        if (is_null($topic->created_at)) {
            return false;
        }
        $time = Carbon::now()->diffInMinutes(Carbon::parse($topic->created_at));
        return $time <= 60;
    }
}