<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Requests\ReplayMapCreateAdminRequest;
use App\Replay;
use App\ReplayMap;
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
        $data = ReplayMap::withCount('replay');

        if ($request->has('text') && $request->get('text')){
            $data->where(function ($q) use ($request){
                $q->where('id', 'like', "%{$request->get('text')}%")
                    ->orWhere('name', 'like', "%{$request->get('text')}%");
            });
        }
        if ($request->has('sort') && $request->get('sort')){
            $data->orderBy($request->get('sort'));
        }

        $data = $data->paginate(50);
        return view('admin.replay.map.list')->with(['data' => $data, 'request_data' => $request->all()]);
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
        $data = $request->validated();

        $path = str_replace('public', '/storage',$data['file']->store('public/maps'));
        $data['url'] = $path;
        unset($data['file']);

        ReplayMap::create($data);

        return back();
    }
}
