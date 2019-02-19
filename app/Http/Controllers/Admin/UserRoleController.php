<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleSaveRequest;
use App\Services\User\UserRoleService;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRoleController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.role.list')->with('data', UserRole::withCount('users')->paginate(20));
    }

    /**
     * @param $role_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($role_id)
    {
        return view('admin.user.role.edit')->with('role', UserRole::find($role_id));
    }

    /**
     * @param RoleSaveRequest $request
     * @param $role_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(RoleSaveRequest $request, $role_id)
    {
        UserRole::where('id', $role_id)->update($request->validated());
        return back();
    }

    /**
     * @param $role_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($role_id)
    {
        UserRoleService::remove($role_id);
        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.user.role.add');
    }

    /**
     * @param RoleSaveRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(RoleSaveRequest $request)
    {
        UserRole::create($request->validated());
        return back();
    }
}
