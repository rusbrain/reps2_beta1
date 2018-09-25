<?php

namespace App\Http\Controllers;

use App\Country;
use App\File;
use App\Http\Requests\User\UpdateProfileRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

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
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        if (!$request->has('user') || !$user = User::find($request->get('user'))){
            abort(404);
        }

        return view('user.profile')->with('user', $user);
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
        $user_data = $request->all();

        foreach ($user_data as $key=>$item){
            if (is_null($item)){
                unset($user_data[$key]);
            }
        }

        if (isset($user_data['country'])){
            $user_data['country_id'] = $user_data['country'];
            unset($user_data['country']);
        }

        if ($request->file('avatar')){
            $path = str_replace('public', '/storage',$request->file('avatar')->store('public/avatars'));

            $file = File::create([
                'user_id' => Auth::id(),
                'title' => 'Аватар '.Auth::user()->name,
                'link' => $path
                ]);

            $user_data['file_id'] = $file->id;
        }

        Auth::user()->update($user_data);

        return redirect('/info.php?user='.Auth::id());
    }
}
