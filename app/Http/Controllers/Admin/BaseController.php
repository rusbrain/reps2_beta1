<?php

namespace App\Http\Controllers\Admin;

use App\ForumTopic;
use App\Http\Requests\QuickEmailRequest;
use App\Mail\QuickEmail;
use App\Replay;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BaseController extends Controller
{
    /**
     * Get dashboard of Admin panel
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $topic_count = ForumTopic::where(function ($q){
            $q->whereNull('start_on')
                ->orWhere('start_on','<=', Carbon::now()->format('Y-M-d'));
        })->count();
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendQuickEmail(QuickEmailRequest $request)
    {
        Mail::send(new QuickEmail($request->get('content'), $request->get('subject'), $request->get('emailto')));
        return back();
    }
}
