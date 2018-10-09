<?php

namespace App\Http\Controllers\Admin;

use App\ForumTopic;
use App\Http\Requests\QuickEmailRequest;
use App\Mail\QuickEmail;
use App\Replay;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BaseController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $topic_count = ForumTopic::count();
        $gosu_replay_count = Replay::gosuReplay()->count();
        $user_replay_count = Replay::userReplay()->count();
        $user_count = User::count();
        return view('admin.dashboard')->with([
            'topic_count'       => $topic_count,
            'gosu_replay_count' => $gosu_replay_count,
            'user_replay_count' => $user_replay_count,
            'user_count'        => $user_count,
        ]);
    }

    /**
     * Send quick email
     *
     * @param QuickEmailRequest $request
     */
    public function sendQuickEmail(QuickEmailRequest $request)
    {
        Mail::to($request->get('emailto'))
            ->send(new QuickEmail($request->get('content'), $request->get('subject')));
    }
}
