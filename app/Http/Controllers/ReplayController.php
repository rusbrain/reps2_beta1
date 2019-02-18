<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Country;
use App\Http\Requests\ReplaySearchRequest;
use App\Http\Requests\ReplayStoreRequest;
use App\Http\Requests\ReplayUpdateRequest;
use App\Replay;
use App\ReplayMap;
use App\ReplayType;
use App\Services\Replay\ReplayService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReplayController extends Controller
{
    /**
     * Replay group name
     *
     * @var string
     */
    public $replay_group = "";

    /**
     * Replay query function name
     *
     * @var string
     */
    public $method_get = "";

    /**
     * Get list of all Replay
     *
     * @param ReplaySearchRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(ReplaySearchRequest $request)
    {
        return ReplayService::getList(ReplayService::listReplay($request,$this), $this->replay_group);
    }

    /**
     * Get replay from Id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $replay =ReplayService::getReplayQuery(Replay::where('id', $id))->first();
        if ($replay){
            $comments = Comment::getObjectComments($replay);
            return view('replay.show')->with(['replay' => $replay, 'comments' => $comments]);
        }
        return abort(404);
    }

    /**
     * Get view for create new replay
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('replay.create')->with([
            'types' => ReplayType::all(),
            'maps' => ReplayMap::all(),
            'countries' => Country::all(),
        ]);
    }

    /**
     * Save new Replay
     *
     * @param ReplayStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReplayStoreRequest $request)
    {
        return redirect()->route('replay.get', ['id' => ReplayService::store($request)]);
    }

    /**
     * Get view for update replay
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $replay = Replay::where('id', $id)->with('file')->first();
        if(!$replay){
            return abort(404);
        }
        return view('replay.edit', ['replay' => $replay]);
    }

    /**
     * Save update of replay
     *
     * @param ReplayUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReplayUpdateRequest $request, $id)
    {
        $replay = Replay::find($id);
        if($replay){
            Replay::updateReplay($request, $replay);
            return redirect()->route('replay.get', ['id' => $replay->id]);
        }
        return abort(404);
    }


    /**
     * Get replay by user
     *
     * @param int $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserReplay($user_id = 0)
    {
        if (!$user_id){
            $user_id = Auth::id();
        }
        $method = $this->method_get;
        return ReplayService::getList(Replay::$method()->where('user_id',$user_id), $this->replay_group);
    }

    public function getAllUserReplay($user_id = 0)
    {
        if (!$user_id){
            $user_id = Auth::id();
        }
        return ReplayService::getList(Replay::where('user_id',$user_id), $this->replay_group);
    }

    /**
     * Get Replay by type
     *
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReplayByType($type)
    {
        $type = ReplayType::where('name', $type)->first();
        if(!$type){
            return abort(404);
        }
        $method = $this->method_get;
        return ReplayService::getList(Replay::$method()->where('type_id',$type->id), $this->replay_group.': '.$type->title);
    }

    /**
     * Download replay file
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($id)
    {
        $replay = Replay::find($id);
        if(!$replay){
            return abort(404);
        }
        return Storage::download(str_replace('/storage','public', ReplayService::download($replay)));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $replay = Replay::find($id);
        if (!$replay){
            return abort(404);
        }
        if ($replay->user_id != Auth::id()){
            return abort(403);
        }
        ReplayService::destroy($replay);
        return redirect()->route('replay.gosus');
    }
}
