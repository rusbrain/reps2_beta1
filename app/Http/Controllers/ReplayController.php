<?php

namespace App\Http\Controllers;


use App\Country;
use App\File;
use App\Http\Requests\ReplaySearchRequest;
use App\Http\Requests\ReplayStoreRequest;
use App\Http\Requests\ReplayUpdateRequest;
use App\Replay;
use App\ReplayMap;
use App\ReplayType;
use App\User;
use App\UserReputation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Project;

class ReplayController extends Controller
{
    /**
     * Replay group name
     *
     * @var string
     */
    protected $replay_group = "";

    /**
     * Replay query function name
     *
     * @var string
     */
    protected $method_get = "";

    /**
     * Get list of all Replay
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $method = $this->method_get;

        return $this->getList(Replay::$method());
    }

    /**
     * get Replay view list
     *
     * @param $query
     * @param bool $title
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function getList($query, $title = false)
    {
        $data = $this->getReplay($query)
            ->orderBy('created_at')
            ->paginate(20);

        return view('replay.list')->with(['replays' => $data, 'title'=>($title?$title:$this->replay_group)]);
    }

    /**
     * get Replay query
     *
     * @param Replay $replay
     * @return Replay|\Illuminate\Database\Eloquent\Builder
     */
    private function getReplay(Builder $replay)
    {
        return $replay->with(User::getUserWithReputationQuery())
                ->withCount('comments', 'positive','negative')
                ->with('type','user', 'map','first_country','second_country');
    }

    /**
     * Get replay from Id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $replay = $this->getReplay(Replay::where('id', $id))->first();

        if ($replay){
            $comments = $replay->comments()->with(User::getUserWithReputationQuery())
                ->orderBy('created_at')->paginate(20);

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
        return view('replay.create')->with(['types' => ReplayType::all(), 'maps' => ReplayMap::all(), 'countries' => Country::all(), 'races' => Replay::$races]);
    }

    /**
     * Save new Replay
     *
     * @param ReplayStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReplayStoreRequest $request)
    {
        $replay_data = $request->validated();

        $title = 'Replay '.$request->has('title')?$request->get('title'):'';
        $file = File::storeFile($replay_data['replay'], 'replays', $title);

        $replay_data['file_id'] = $file->id;
        $replay_data['user_id'] = Auth::id();

        unset($replay_data['replay']);

        $replay = Replay::create($replay_data);

        return redirect()->route('replay.get', ['id' => $replay->id]);
    }

    /**
     * Get view for update replay
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $replay = Replay::where('id', $id)->withCount('comments', 'positive','negative')->first();

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
            $replay_data = $request->validated();

            if($request->has('replay')){
                File::removeFile($replay->file_id);

                $title = 'Replay '.$request->has('title')?$request->get('title'):'';
                $file = File::storeFile($replay_data['replay'], 'replays', $title);

                $replay_data['file_id'] = $file->id;

                unset($replay_data['replay']);
            }

            if ($request->has('map_id') && $request->get('map_id') === null){
                $replay_data['map_id'] = 0;
            }

            if ($request->has('championship') && $request->get('championship') == ''){
                $replay_data['championship'] = '';
            }

            if ($request->has('evaluation') && $request->get('evaluation') == ''){
                $replay_data['evaluation'] = '';
            }

            if ($request->has('length') && $request->get('length') == ''){
                $replay_data['length'] = '00:00:00';
            }

            $replay = Replay::where('id', $id)->update($replay_data);

            return redirect()->route('replay.get', ['id' => $replay->id]);
        }

        return abort(404);
    }

    /**
     * Get replay by user
     *
     * @param int $user_id
     */
    public function getUserReplay($user_id = 0)
    {
        if (!$user_id){
            $user_id = Auth::id();
        }

        $method = $this->method_get;
        $this->getList(Replay::$method()->where('user_id',$user_id));
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
        return $this->getList(Replay::$method()->where('type_id',$type->id), $this->replay_group.' '.$type);
    }

    /**
     * Download replay file
     *
     * @param $id
     */
    public function download($id)
    {
        $replay = Replay::find($id);

        if(!$replay){
            return abort(404);
        }

        $file = $replay->file()->first();
        
        $replay->downloaded = $replay->downloaded+1;
        
        $replay->save();

        return Storage::download(str_replace('/storage','public', $file->link));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

        $file = $replay->file()->first();
        File::removeFile($file->id);

        $replay->user_rating()->delete();
        $replay->comments()->delete();
        $replay->delete();

        UserReputation::refreshUserRating(Auth::id());

        return redirect()->route('replay.gosus');
    }
}
