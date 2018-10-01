<?php

namespace App\Http\Controllers;

use App\ForumSection;
use App\ForumTopic;
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function initTopic(Request $request)
    {
        $topic_id = false;

        $topic = ForumTopic::where('reps_id', $request->get('topic'))->orWhere('id', $request->get('topic'))->get();

        if(count($topic)>1){
            $topic_id = $topic->where('reps_id', $request->get('forum'))->first()->id;
        } elseif (count($topic) == 1){
            $topic_id = $topic->first()->id;
        }

        if (!$topic_id){
            return redirect('/');
        }

        return redirect()->route('forum.topic.index', ['id' => $topic_id]);
    }

    /**
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function columns()
    {
        return redirect()->route('forum.section.index', ['name' => 'columns']);
    }

    /**
     * Redirect to forum sections
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function news(Request $request)
    {
        if ($request->has('search')){
            return redirect()->route('forum.index');
        }

        if ($request->has('news')){
            if ($request->has('id')){
                $topic = ForumTopic::where('reps_id', $request->get('id'))->where('reps_section', $request->get('news'))->first();

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

    public function freeReplays(Request $request)
    {

    }

    public function replays(Request $request)
    {

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