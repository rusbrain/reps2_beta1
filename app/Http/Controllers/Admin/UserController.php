<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\User\UpdateProfileRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Get user list
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $users = User::with('role')->withCount('topics', 'replays','user_galleries');

        if ($request->has('search') && null !==$request->get('search')){
            $users->where(function ($query) use ($request)
            {
                $query->where('id', $request->get('search'))
                    ->orWhere('name', 'like', '%'.$request->get('search').'%')
                    ->orWhere('email', 'like', '%'.$request->get('search').'%');
            });
        }

        if ($request->has('country') && null !==$request->get('country')){
            $users->where('country_id', $request->get('country'));
        }

        if ($request->has('email_verified') && null !==$request->get('email_verified')){
            if ($request->get('email_verified') == 0){
                $users->whereNull('email_verified_at');
            } else{
                $users->whereNotNull('email_verified_at');
            }
        }

        if ($request->has('role') && null !==$request->get('role')){
            $users->where('user_role_id', $request->get('role'));
        }

        if ($request->has('is_ban') && null !==$request->get('is_ban')){
            $users->where('is_ban', $request->get('is_ban'));
        }

        if($request->has('sort') && null !==$request->get('sort')){
            $users->orderBy($request->get('sort'));
        } else{
            $users->orderBy('created_at');
        }

        $users = $users->paginate(50)->appends($request->all());

        return view('admin.user.user_list')->with(['data'=> $users, 'request_data' => $request->all()]);
    }

    /**
     * GEt user profile page
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserProfile($user_id)
    {
        return view('admin.user.profile')->with('user', User::getAllUserProfile($user_id));
    }

    /**
     * Get user edit profile page
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditUserProfile($user_id)
    {
        return view('admin.user.profile_edit')->with('user', User::getUserProfile($user_id));
    }

    /**
     * Save updated user data
     *
     * @param UpdateProfileRequest $request
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUserProfile(UpdateProfileRequest $request, $user_id)
    {
        User::updateData($request, $user_id);

        return redirect()->route('admin.user.profile.edit', ['id' => $user_id]);
    }

    /**
     * Banning user
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function banUser($user_id)
    {
        User::where('id', $user_id)->update(['is_ban' => 1]);

        return back();
    }

    /**
     * User permission
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notBanUser($user_id)
    {
        User::where('id', $user_id)->update(['is_ban' => 0]);

        return back();
    }

    /**
     * Soft delete user
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeUser($user_id)
    {
        $user = User::find($user_id);

        $user->user_galleries()->delete();
        $user->dialogues()->delete();
        $user->user_friends()->delete();
        $user->user_friendly()->delete();

        User::where('id', $user_id)->delete();

        return back();
    }
}