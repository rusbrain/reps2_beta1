<?php

namespace App\Http\Controllers;

use App\ForumSection;
use App\ForumTopic;
use App\Replay;
use App\User;
use Illuminate\Http\Request;

class RedirectOldURL extends Controller
{
    /**
     * Redirect to forum
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forum(Request $request)
    {
        if ($request->has('forum')){
            return $this->initSection($request);
        }

        if ($request->has('topic')){
            return $this->initTopic($request);
        }

        return redirect()->route('forum.index');
    }

    /**
     * Get topic for redirect
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function initTopic(Request $request)
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
    private function initSection(Request $request)
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
     * Redirect to forum section columns
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function columns(Request $request)
    {
        if ($request->has('id')){
            $comment = ForumTopic::where('reps_id', $request->get('id'))->where('reps_section', 'columns')->first();

            if ($comment){
                $comment_id = $comment->id;
                return redirect()->route('forum.topic.index', ['id' => $comment_id]);
            }


        }

        return redirect()->route('forum.section.index', ['name' => 'columns']);
    }

    /**
     * Redirect to forum sections
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function news(Request $request)
    {
        if ($request->has('search')){
            return redirect()->route('forum.index');
        }

        if ($request->has('news')){
            if ($request->has('id')){
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
                    $topic_id = $topic->id;

                    return redirect()->route('forum.topic.index', ['id' => $topic_id]);
                }

                return redirect('/');
            }

            return redirect()->route('forum.section.index', ['name' => $request->get('news')]);
        }
    }

    /**
     * Redirect to user profile
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function info(Request $request)
    {
        if ($request->has('user')){
            $user = User::where('reps_id', $request->get('user'))->first();

            if (!$user){
                $user_id = $request->get('user');
            } else {
                $user_id = $user->id;
            }

            return redirect()->route('user_profile', ['id' => $user_id]);
        }

        return redirect('/');
    }

    /**
     * Redirect to user edit profile
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function user()
    {
        return redirect()->route('edit_profile');
    }

    /**
     * Redirect to users replay
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function freeReplays(Request $request)
    {
        if($request->has('id')){
            $replay_id = $this->getReplayId($request);

            if ($replay_id){
                return redirect()->route('replay.get',['id'=> $replay_id]);
            }
        }

        return redirect()->route('replay.users');
    }

    /**
     * Redirect to gosu replay
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function replays(Request $request)
    {
        if($request->has('id')){
             $replay_id = $this->getReplayId($request);

             if ($replay_id){
                 return redirect()->route('replay.get',['id'=> $replay_id]);
             }
        }

        if($request->has('type')){
            return redirect()->route('replay.gosu_type',['type'=> $request->get('type')]);
        }

        return redirect()->route('replay.gosus');
    }

    /**
     * Get Id of replay for redirect
     *
     * @param Request $request
     * @return bool
     */
    private function getReplayId(Request $request)
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

    public function sc2(Request $request)
    {
        return redirect('/');
    }

    public function userBars(Request $request)
    {
        return redirect('/');
    }

    public function files(Request $request)
    {
        return redirect('/');
    }

    public function donate(Request $request)
    {
        return redirect('/');
    }

    public function rating(Request $request)
    {
        return redirect('/');
    }

    /**
     * Redirect to registration page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registration()
    {
        return redirect()->route('registration_form');
    }
}
