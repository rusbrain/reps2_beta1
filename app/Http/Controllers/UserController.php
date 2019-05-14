<?php

namespace App\Http\Controllers;

use App\{Country, IgnoreUser, User, UserFriend};
use App\Http\Requests\User\UpdateProfileRequest;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Get user profile view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if (Auth::user() && IgnoreUser::me_ignore($id)){
            return abort(403);
        }
        $user = User::getUserDataById($id);
        if (!$user){
            abort(404);
        }
        $friends = UserFriend::getFriends($user);
        $friendly = UserFriend::getFriendlies($user);

        return view('user.profile')->with([
            'friends' => $friends,
            'friendly' => $friendly,
            'user' => $user->load('avatar')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('user.edit_profile')->with(['user'=> Auth::user(), 'countries' => Country::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateProfileRequest $request)
    {
        UserService::updateData($request, Auth::id());

        return redirect()->route('user_profile', ['id' => Auth::id()]);
    }
}
