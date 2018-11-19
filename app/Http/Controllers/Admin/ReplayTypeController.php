<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleSaveRequest;
use App\Replay;
use App\ReplayType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplayTypeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.replay.type.list')->with('data', ReplayType::withCount('replay')->paginate(20));
    }

    /**
     * @param $type_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($type_id)
    {
        return view('admin.replay.type.edit')->with('type', ReplayType::find($type_id));
    }

    /**
     * @param RoleSaveRequest $request
     * @param $type_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(RoleSaveRequest $request, $type_id)
    {
        ReplayType::where('id', $type_id)->update($request->validated());
        return back();
    }

    /**
     * @param $type_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($type_id)
    {
        Replay::where('type_id', $type_id)->update(['type_id' => 0]);
        ReplayType::where('id', $type_id)->delete();

        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.replay.type.add');
    }

    /**
     * @param RoleSaveRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(RoleSaveRequest $request)
    {
        ReplayType::create($request->validated());
        return back();
    }
}
