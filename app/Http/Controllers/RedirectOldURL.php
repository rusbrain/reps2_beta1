<?php

namespace App\Http\Controllers;

use App\ForumSection;
use App\User;
use Illuminate\Http\Request;

class RedirectOldURL extends Controller
{
    /**
     * Redirect to forum
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function forum(Request $request)
    {
        if ($request->has('forum')){
            $section_name = ForumSection::where('reps_id', $request->get('forum'))->orWhere('id', $request->get('forum'))->get();

            if(!$section_name){
                $section_name = ForumSection::where('id', $request->get('forum'))->first()->name;
            }

            if (!$section_name){
                return abort(404);
            }

            return redirect()->route('forum.section.index', ['name' => $section_name]);
        }

        return redirect()->route('forum.index');
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
            return redirect()->route('forum.section.index', ['name' => $request->get('news')]);
        }
    }

    /**
     * Redirect to user profile
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function info(Request $request)
    {
        if ($request->has('user')){
            $user_id = User::where('reps_id', $request->get('user'))->first()->id;

            if (!$user_id){
                $user_id = $request->get('user');
            }

            return redirect()->route('user_profile', ['id' => $user_id]);
        }

        return abort(404);
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
