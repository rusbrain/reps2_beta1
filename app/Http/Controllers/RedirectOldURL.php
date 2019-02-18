<?php

namespace App\Http\Controllers;

use App\Services\Base\RedirectOldUrlService;
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
            return RedirectOldUrlService::initSection($request);
        }

        if ($request->has('topic')){
            return RedirectOldUrlService::initTopic($request);
        }
        return redirect()->route('forum.index');
    }

    /**
     * Redirect to forum section columns
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function columns(Request $request)
    {
        $column_id = RedirectOldUrlService::getColumnsId($request);

        if ($column_id){
                return redirect()->route('forum.topic.index', ['id' => $column_id]);
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
            return RedirectOldUrlService::getNewsRedirect($request);
        }
        return redirect('/');
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
            $replay_id = RedirectOldUrlService::getReplayId($request);

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
             $replay_id = RedirectOldUrlService::getReplayId($request);

             if ($replay_id){
                 return redirect()->route('replay.get',['id'=> $replay_id]);
             }
        }

        if($request->has('type')){
            return redirect()->route('replay.gosu_type',['type'=> $request->get('type')]);
        }
        return redirect()->route('replay.gosus');
    }

    public function files(Request $request)
    {
    }

    public function home()
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
