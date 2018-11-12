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
     * @param ReplaySearchRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(ReplaySearchRequest $request)
    {
        $method = $this->method_get;

        $query = Replay::$method();

        $request_data = $request->validated();

        if ($request_data)
            foreach ($request_data as $key=>$request_datum) {
                if ($key == 'text'){
                    $query->where(function ($q) use ($request_datum){
                        $q->where('title', 'like', "%$request_datum%")
                            ->orWhere('content', 'like', "%$request_datum%")
                            ->orWhere('championship', 'like', "%$request_datum%");
                    });
                }elseif($key == 'sort_by'){
                    $query->orderBy($request_datum, ($request_data['sort_type']??'desc'));
                }else{
                    $query->where($key, $request_datum);
                }
            }

        return $this->getList($query);
    }

    /**
     * get Replay view list
     *
     * @param $query
     * @param bool $title
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList($query, $title = false)
    {
        $data = $this->getReplay($query)
            ->orderBy('created_at')
            ->paginate(20);

        return view('replay.list')->with(['replays' => $data, 'title'=>($title !== false?$title:$this->replay_group)]);
    }

    /**
     * get Replay query
     *
     * @param \Illuminate\Database\Eloquent\Builder $replay
     * @return Replay|\Illuminate\Database\Eloquent\Builder
     */
    private function getReplay(Builder $replay)
    {
        return $replay->with(User::getUserWithReputationQuery())
                ->with(['user'=> function($q){
                $q->withTrashed();
            }])
                ->with('user')
                ->with(['user_rating' => function($query){
                    $query->where('user_id', Auth::id());
                }]);
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
        $replay = Replay::where('id', $id)->first();

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
        return $this->getList(Replay::$method()->where('type_id',$type->id), $this->replay_group.': '.$type->title);
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


        return redirect()->route('replay.gosus');
    }
}
