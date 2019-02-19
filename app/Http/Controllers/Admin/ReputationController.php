<?php

namespace App\Http\Controllers\Admin;

use App\Services\Base\{BaseDataService, AdminViewService};
use App\{User, UserReputation};
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
        return BaseDataService::getPaginationData(AdminViewService::getReputation($repuntation), AdminViewService::getPagination($repuntation));
    }

    /**
     * @param $user_id
     * @param $reputation_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($user_id, $reputation_id)
    {
        UserReputation::where('id', $reputation_id)->delete();
        return back();
    }
}
