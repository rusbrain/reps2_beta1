<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\ForumTopic;
use App\Http\Requests\QuickEmailRequest;
use App\Mail\QuickEmail;
use App\Replay;
use App\ReplayMap;
use App\User;
use App\UserGallery;
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

    /**
     * @param $object_name
     * @param $id
     * @return array
     */
    public function getComments($object_name, $id)
    {
        $relation   = Comment::getObjectRelation($object_name);
        $comments   = [];

        if ($relation){
            $comments = Comment::where('relation', $relation)->where('object_id', $id)->with('user.avatar')->orderBy('created_at', 'desc')->paginate(20);
        }

        $table      = (string) view('admin.comment')        ->with(['data' => $comments]);
        $pagination = (string) view('admin.user.pagination')->with(['data' => $comments]);

        return ['table' => $table, 'pagination' => $pagination];
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeComment($id)
    {
        Comment::find($id)->delete();
        return back();
    }
}
