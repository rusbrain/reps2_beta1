<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 9:36
 */

namespace App\Services\Base;

use App\ForumSection;
use App\ForumTopic;
use Illuminate\Http\Request;

class RedirectOldUrlService
{
    /**
     * Get topic for redirect
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function initTopic(Request $request)
    {
        $topic_id = false;

        $topic = ForumTopic::where('reps_id', $request->get('topic'))->orWhere('id', $request->get('topic'))->get();

        if(count($topic)>1){
            $topic_id = $topic->where('reps_id', $request->get('topic'))->first()->id;
        } elseif (count($topic) == 1){
            $topic_id = $topic->first()->id;
        }

        if (!$topic_id){
            return redirect('/');
        }

        return redirect()->route('forum.topic.index', ['id' => $topic_id]);
    }

    /**
     * Get section for redirect
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function initSection(Request $request)
    {
        $section_name = false;

        $section = ForumSection::where('reps_id', $request->get('forum'))->orWhere('id', $request->get('forum'))->get();

        if(count($section)>1){
            $section_name = $section->where('reps_id', $request->get('forum'))->first()->name;
        } elseif (count($section) == 1){
            $section_name = $section->first()->name;
        }

        if (!$section_name){
            return redirect('/');
        }

        return redirect()->route('forum.section.index', ['name' => $section_name]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function getColumnsId(Request $request)
    {
        if ($request->has('id')) {
            $column = ForumTopic::where('reps_id', $request->get('id'))->where('reps_section', 'columns')->first();

            if ($column) {
                return $column->id;
            }
        }

       return false;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function getNewsId(Request $request)
    {
        $topic = ForumTopic::where('reps_id', $request->get('id'))->where(function ($q) use ($request){
            $q-> where('reps_section', 'like', "%".$request->get('news')."%")
                ->orWhere('reps_section', 'like','%news%')
                ->orWhere('reps_section', 'like','%article%')
                ->orWhere('reps_section', 'like','%strategy%')
                ->orWhere('reps_section', 'like','%coverage%')
                ->orWhere('reps_section', 'like','%event%')
                ->orWhere('reps_section', 'like','%interview%');
        })->first();

        if($topic){
            return $topic->id;
        }

        return false;
    }

    /**
     * Get Id of replay for redirect
     *
     * @param Request $request
     * @return bool
     */
    public static function getReplayId(Request $request)
    {
        $replay_id = false;

        $replays =Replay::where('id', $request->get('id'))->orWhere('reps_id', $request->get('id'))->get();

        if(count($replays)>1){
            $replay_id = $replays->where('reps_id', $request->get('id'))->first()->id;
        } elseif (count($replays) == 1){
            $replay_id = $replays->first()->id;
        }

        return $replay_id;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function getNewsRedirect(Request $request)
    {
        if ($request->has('id')){
            $topic_id = RedirectOldUrlService::getNewsId($request);

            if($topic_id){
                return redirect()->route('forum.topic.index', ['id' => $topic_id]);
            }
            return redirect('/');
        }
        return redirect()->route('forum.section.index', ['name' => $request->get('news')]);
    }
}