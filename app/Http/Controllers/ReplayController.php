<?php

namespace App\Http\Controllers;

use App\{
    Comment, Country, Replay, ReplayMap, ReplayType
};
use App\Http\Requests\{
    ReplaySearchRequest, ReplayStoreRequest, ReplayUpdateRequest
};
use App\Services\Replay\ReplayService;
use Illuminate\Support\Facades\{
    Auth, Storage
};

class ReplayController extends Controller
{
    /**
     * Replay group name
     *
     * @var string
     */
    public $replay_group = "";

    /**
     * Replay type
     *
     * @var string
     */
    public $replay_type = "";

    /**
     * Replay query function name
     *
     * @var string
     */
    public $method_get = "";

    /**
     * Get view list of all Replay
     *
     * @param bool $type
     * @return $this
     */
    public function index($type = false)
    {
        if ($type) {
            $type = $this->checkReplayType($type);
        }
        return view('replay.list')->with([
            'title' => (!$type) ? $this->replay_group : $this->replay_group . ': ' . $type->title,
            'replay_type' => $this->replay_type,
            'type' => ($type) ? $type->name : $type
        ]);
    }

    /**
     * Get list of all Replay
     *
     * @param ReplaySearchRequest $request
     * @return array
     */
    public function paginate(ReplaySearchRequest $request)
    {
        return ReplayService::getList(ReplayService::listReplay($request, $this), $this->replay_group);
    }

    /**
     * Get replay from Id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $replay = ReplayService::getReplayQuery(Replay::where('id', $id))->first();
        if ($replay) {
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
        if (!$replay) {
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
        if ($replay) {
            ReplayService::updateReplay($request, $replay);
            return redirect()->route('replay.get', ['id' => $replay->id]);
        }
        return abort(404);
    }

    /**
     * Get replay by user
     *
     * @param int $user_id
     * @return array
     */
    public function getUserReplay($user_id = 0)
    {
        if (!$user_id) {
            $user_id = Auth::id();
        }
        return view('replay.list')->with([
            'title' => $this->replay_group,
            'replay_type' => 'my_'.$this->replay_type,
            'user_id' => $user_id
        ]);
    }

    /**
     * Pagination of User's replays list
     *
     * @param int $user_id
     * @return array
     */
    public function getUserReplayPaginate($user_id = 0)
    {
        if (!$user_id) {
            $user_id = Auth::id();
        }
        $method = $this->method_get;
        return ReplayService::getList(Replay::$method()->where('user_id', $user_id), $this->replay_group);
    }

    /**
     * @param int $user_id
     * @return array
     */
    public function getAllUserReplay($user_id = 0)
    {
        if (!$user_id) {
            $user_id = Auth::id();
        }
        return ReplayService::getList(Replay::where('user_id', $user_id), $this->replay_group);
    }

    /**
     * Get Replay list by type
     *
     * @param $type
     * @return array
     */
    public function getReplayByType($type)
    {
        $type = $this->checkReplayType($type);
        $method = $this->method_get;
        return ReplayService::getList(Replay::$method()->where('type_id', $type->id),
            $this->replay_group . ': ' . $type->title);
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
        if (!$replay) {
            return abort(404);
        }
        return Storage::download(str_replace('/storage', 'public', ReplayService::download($replay)));
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
        if (!$replay) {
            return abort(404);
        }
        if ($replay->user_id != Auth::id()) {
            return abort(403);
        }
        ReplayService::remove($id);
        return redirect()->route('replay.gosus');
    }

    /**
     * @param $type
     */
    public function checkReplayType($type)
    {
        $type = ReplayType::where('name', $type)->first();
        if (!$type) {
            return abort(404);
        }
        return $type;
    }
}
