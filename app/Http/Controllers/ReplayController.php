<?php

namespace App\Http\Controllers;

use App\{Comment, Country, Replay, ReplayMap, ReplayType, Services\Base\UserActivityLogService};
use App\Http\Requests\{
    ReplaySearchRequest, ReplayStoreRequest, ReplayUpdateRequest
};
use App\Services\Replay\ReplayService;
use Illuminate\Support\Facades\{
    Auth, Storage
};
use App\Services\GeneralViewHelper;

class ReplayController extends Controller
{
    /**
     * Replay group name
     *
     * @var string
     */
    public $replay_group = "Поиск реплеев";

    /**
     * Replay type
     *
     * @var string
     */
    public $replay_type = "search";

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
     * @param ReplaySearchRequest $request
     * @return $this
     */

    public $general_helper;

    public function __construct() {
        $this->general_helper = new GeneralViewHelper;
    }
    
    public function index($type = false, ReplaySearchRequest $request)
    {
        $request_data = '';
        if ($type) {
            $type = $this->checkReplayType($type);
        }
        if($this->replay_type == 'search'){
            $request_data = ReplayService::getRequestString($request);
        }

        return view('replay.list')->with([
            'title' => (!$type) ? $this->replay_group : $this->replay_group . ': ' . $type->title,
            'replay_type' => $this->replay_type,
            'type' => ($type) ? $type->name : $type,
            'request' => $request_data,
            'search_text' => $request->get('text'),
            'search_section' => HomeController::SEARCH_REPLAY,
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
        $newReplay = ReplayService::store($request);

        UserActivityLogService::log(UserActivityLogService::EVENT_CREATE_REPLAY, $newReplay);

        return redirect()->route('replay.get', ['id' => $newReplay->id]);
    }

    /**
     * Get view for update replay
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        //check editable users
        $replay = Replay::where('id', $id)->with('file')->first();

        if(Auth::id() == $replay->user_id || $this->general_helper->isAdmin() || $this->general_helper->isModerator()){
            if (!$replay) {
                return abort(404);
            }
            return view('replay.edit', ['replay' => $replay]);
        }
        return abort(404);        
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
        if(Auth::id() == $replay->user_id || $this->general_helper->isAdmin() || $this->general_helper->isModerator()){
            if ($replay) {
                ReplayService::updateReplay($request, $replay);
                return redirect()->route('replay.get', ['id' => $replay->id]);
            }
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
            'user_id' => $user_id,
            'request' => ''
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
        return ReplayService::getList(Replay::$method()->where('user_id', $user_id), $this->replay_group, true);
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
        return ReplayService::getList(Replay::where('user_id', $user_id), $this->replay_group, true);
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
        /**@var Replay $replay */
        $replay = Replay::find($id);
        if (!$replay) {
            return abort(404);
        }

        try {
            $link = ReplayService::download($replay);
            if (!$link) {
                throw new \DomainException('Файл отсутствует');
            }
            $file_link = str_replace('/storage', 'public', $link);
            if (!Storage::exists($file_link)) {
                throw new \DomainException('Файл отсутствует');
            }
            $replay->downloaded = $replay->downloaded + 1;
            $replay->save();
            return Storage::download($file_link);

        } catch (\DomainException $e) {
            return view('error', ['error' => $e->getMessage()]);
        }
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
