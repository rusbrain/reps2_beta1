<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Requests\{CommentUpdateRequest,
    ReplaySearchAdminRequest,
    ReplayStoreRequest,
    ReplayUpdateRequest,
    UploadReplayRequest};
use Illuminate\Http\UploadedFile;
use App\{File, Replay, ReplayMap, ReplayType, ReplayUserRating, Country, Services\Replay\ReplayParserService};
use App\Services\Base\{BaseDataService, AdminViewService};
use App\Services\Comment\CommentService;
use App\Services\Replay\ReplayService;
use App\Http\Controllers\Controller;

class ReplayController extends Controller
{
    /**
     * @param ReplaySearchAdminRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ReplaySearchAdminRequest $request)
    {
        $data = ReplayService::search($request)->count();
        return view('admin.replay.replays')->with(['replay_count' => $data, 'request_data' => $request->validated()]);
    }

    /**
     * @param ReplaySearchAdminRequest $request
     * @return array
     */
    public function pagination(ReplaySearchAdminRequest $request)
    {

        $data = Replay::getReplay($request);//dd($data);
        return BaseDataService::getPaginationData(
            AdminViewService::getReplay($data),
            AdminViewService::getPagination($data),
            AdminViewService::getReplayPopUp($data)
        );
    }

    /**
     * Get replays by user
     *
     * @param ReplaySearchAdminRequest $request
     * @param $user_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getReplayByUser(ReplaySearchAdminRequest $request, $user_id)
    {
        return view('admin.replay.replays')->with(ReplayService::getReplayByUser($request,$user_id));
    }

    /**
     * @param $replay_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserRating($replay_id)
    {
        $data = ReplayUserRating::where('replay_id', $replay_id)->with('user')->orderBy('created_at', 'desc')->limit(100)->get();
        return view('admin.replay.user_rating')->with('data', $data);
    }

    /**
     * @param $replay_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($replay_id)
    {
        Replay::where('id', $replay_id)->update(['approved' => 1]);
        return back();
    }

    /**
     * @param $replay_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notApprove($replay_id)
    {
        Replay::where('id', $replay_id)->update(['approved' => 0]);
        return back();
    }

    /**
     * @param $replay_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($replay_id)
    {
       ReplayService::remove($replay_id);
        return back();
    }

    /**
     * @param $replay_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReplay($replay_id)
    {
        return view('admin.replay.view')->with('replay', $this->getReplayObject($replay_id));
    }

    /**
     * @param CommentUpdateRequest $request
     * @param $replay_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendComment(CommentUpdateRequest $request, $replay_id)
    {
        $data = $request->validated();
        CommentService::create($data, Comment::RELATION_REPLAY, $replay_id);
        return back();
    }

    /**
     * @param $replay_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($replay_id)
    {
        $replay = $this->getReplayObject($replay_id);
        if (!$replay) {
            return abort(404);
        }
        $currentFileId = old('file_id', $replay->file_id);
        $file = null;
        if ($currentFileId) {
            $file = File::find($currentFileId);
        }
        return view('admin.replay.edit')->with(
            [
                'replay'=> $replay,
                'types' => ReplayType::all(),
                'maps' => ReplayMap::all(),
                'file' => $file
            ]);
    }

    /**
     * @param ReplayUpdateRequest $request
     * @param $replay_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(ReplayUpdateRequest $request, $replay_id)
    {
        $replay = Replay::find($replay_id);

        if($replay){
            ReplayService::updateReplay($request, $replay);
            return back();
        }
        return abort(404);
    }

    /**
     * @param $replay_id
     * @return mixed
     */
    private function getReplayObject($replay_id)
    {
        return Replay::getreplayById($replay_id);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $file = null;
        if (old('file_id')) {
            $file = File::find(old('file_id'));
        }

        return view('admin.replay.create')->with([
            'types' => ReplayType::all(),
            'maps' => ReplayMap::all(),
            'countries' => Country::all(),
            'file' => $file
        ]);
    }

    /**
     * @param ReplayStoreRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(ReplayStoreRequest $request)
    {
        return redirect()->route('admin.replay.view', ['id' => ReplayService::store($request)->id]);
    }


    public function uploadReplayFile(UploadReplayRequest $request, ReplayParserService $replayParserService)
    {
        $file = $request->file;
        /* @var UploadedFile $file */

        try {
            $replayData = $replayParserService->parseFile($file);
        } catch (\Exception $e) {
            return Response::json(['errors' => ['file' => [$e->getMessage()]]], 422);
        }

        $fileModel = File::storeFile($file, 'replays', '', false, false, 'replay');
        $replayData['file_id'] = $fileModel->id;
        return Response::json($replayData, 200);
    }
}
