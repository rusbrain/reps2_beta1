<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ReplayMapCreateAdminRequest;
use App\Replay;
use App\ReplayMap;
use App\Services\Base\BaseDataService;
use App\Services\Base\AdminViewService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplayMapController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data =  ReplayMap::search($request)->count();
        return view('admin.replay.map.list')->with(['maps_count' => $data, 'request_data' => $request->all()]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function pagination(Request $request)
    {
        $data = ReplayMap::search($request, ReplayMap::withCount('replay'))->paginate(20);
        return BaseDataService::getPaginationData(AdminViewService::getMap($data), AdminViewService::getMapPopUp($data), AdminViewService::getPagination($data));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        Replay::where('map_id', $id)->update(['map_id' => 0]);
        ReplayMap::where('id', $id)->delete();
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.replay.map.edit')->with('map', ReplayMap::find($id));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if($request->has('name')){
            ReplayMap::where('id', $id)->update(['name' => $request->get('name')]);
        }
        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.replay.map.add');
    }

    /**
     * @param ReplayMapCreateAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(ReplayMapCreateAdminRequest $request)
    {
        ReplayMap::createMap($request);
        return back();
    }
}
