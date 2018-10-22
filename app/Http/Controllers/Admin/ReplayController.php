<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplayController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexUsers()
    {
        return view('admin.replays');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexGosu()
    {
        return view('admin.replays');
    }

    /**
     * Get replays by user
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReplayByUser($user_id)
    {
        $user = User::find($user_id);
        $replays = $user->replays()->with('type', 'map', 'first_country', 'second_country')->with(['user'=> function($q){
            $q->withTrashed();
        }])->withCount('positive', 'negative', 'comments')->paginate(50);

        return view('admin.replays')->with(['replays' => $replays, 'title' => "Replays $user->name", 'user' => $user]);
    }
}
