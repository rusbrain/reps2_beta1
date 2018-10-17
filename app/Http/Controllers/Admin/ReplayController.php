<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplayController extends Controller
{
    public function indexUsers()
    {
        return view('admin.replays');
    }

    public function indexGosu()
    {
        return view('admin.replays');
    }

    public function getReplayByUser($user_id)
    {
        $user = User::find($user_id);
        $replays = $user->replays()->with('type', 'map', 'first_country', 'second_country', 'user')->withCount('positive', 'negative', 'comments')->paginate(50);

        return view('admin.replays')->with(['replays' => $replays, 'title' => "Replays $user->name", 'user' => $user]);
    }
}
