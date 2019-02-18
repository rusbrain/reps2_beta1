<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\File;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Requests\ReplaySearchAdminRequest;
use App\Http\Requests\ReplayStoreRequest;
use App\Http\Requests\ReplayUpdateRequest;
use App\Replay;
use App\ReplayMap;
use App\ReplayType;
use App\ReplayUserRating;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReplayController extends Controller
{
    /**
     * @param ReplaySearchAdminRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ReplaySearchAdminRequest $request)
    {
        $data = Replay::search($request)->count();
        return view('admin.replay.replays')->with(['replay_count' => $data, 'request_data' => $request->validated()]);
    }

    /**
     * @param ReplaySearchAdminRequest $request
     * @return array
     */
    public function pagination(ReplaySearchAdminRequest $request)
    {
        $data = $data = Replay::search($request,Replay::withCount('user_rating'))
            ->with('user',  'file', 'first_country', 'second_country', 'type', 'map')->withCount( 'positive', 'negative', 'comments')->paginate(50);

        $table      = (string) view('admin.replay.list_table')  ->with(['data' => $data]);
        $pagination = (string) view('admin.user.pagination')    ->with(['data' => $data]);
        $pop_up     = (string) view('admin.replay.list_pop_up') ->with(['data' => $data]);

        return ['table' => $table, 'pagination' => $pagination, 'pop_up' => $pop_up];
    }

    /**
     * Get replays by user
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReplayByUser(ReplaySearchAdminRequest $request, $user_id)
    {
        $user = User::find($user_id);
        $replays = $data = Replay::search($request,Replay::where('user_id', $user_id))->count();

        $request_data = $request->validated();
        $request_data['user_id'] = $user_id;

        return view('admin.replay.replays')->with(['replay_count' => $replays, 'title' => "Replays $user->name", 'user' => $user, 'request_data' => $request_data]);
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
        $replay = Replay::find($replay_id);
        $user_id = $replay->user_id;

        File::removeFile($replay->file_id);
        $replay->positive()->delete();
        $replay->negative()->delete();
        $replay->user_rating()->delete();
        $replay->comments()->delete();

        Replay::where('id', $replay_id)->delete();
        User::recountRating($user_id);

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
        $data['user_id'] = Auth::id();
        $data['relation'] = Comment::RELATION_REPLAY;
        $data['object_id'] = $replay_id;

        Comment::create($data);

        return back();
    }

    /**
     * @param $replay_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($replay_id)
    {
        return view('admin.replay.edit')->with(['replay'=> $this->getReplayObject($replay_id), 'types' => ReplayType::all(), 'maps' => ReplayMap::all()]);
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
            Replay::updateReplay($request, $replay);
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
        return Replay::where('id', $replay_id)
            ->withCount( 'user_rating')
            ->withCount( 'positive', 'negative', 'comments')
            ->with('user.avatar', 'file', 'game_version')->first();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.replay.create')->with(['types' => ReplayType::all(), 'maps' => ReplayMap::all()]);
    }

    /**
     * @param ReplayStoreRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(ReplayStoreRequest $request)
    {
        $replay_data = $request->validated();

        $title = 'Replay '.$request->has('title')?$request->get('title'):'';
        $file = File::storeFile($replay_data['replay'], 'replays', $title);

        $replay_data['file_id'] = $file->id;
        $replay_data['user_id'] = Auth::id();

        unset($replay_data['replay']);

        $replay = Replay::create($replay_data);

        return redirect()->route('admin.replay.view', ['id' => $replay->id]);
    }
}
