<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserReputation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReputationController extends Controller
{
    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index($id){
        $user = User::find($id);
        return view('admin.user.reputation.list')->with(['user' => $user, 'reputation_count' => $user->reputation()->count()]);
    }

    /**
     * @param $id
     * @return array
     */
    public function pagination($id)
    {
        $user = User::find($id);
        $repuntation = $user->reputation()->orderBy('created_at', 'desc')->with('sender', 'topic', 'replay', 'gallery', 'comment')->paginate(50);

        $table = (string) view('admin.user.reputation.list_table')->with(['data' => $repuntation]);
        $pagination = (string) view('admin.user.pagination')->with(['data' => $repuntation]);

        return ['table' => $table, 'pagination' => $pagination];
    }

    /**
     * @param $user_id
     * @param $reputation_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeReputation($user_id, $reputation_id)
    {
        UserReputation::where('id', $reputation_id)->delete();
        return back();
    }
}
