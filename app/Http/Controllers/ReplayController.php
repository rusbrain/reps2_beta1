<?php

namespace App\Http\Controllers;

use App\Country;
use App\File;
use App\Http\Requests\ReplayStoreRequest;
use App\Http\Requests\ReplayUpdateRequest;
use App\Replay;
use App\ReplayMap;
use App\ReplayType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Project;

class ReplayController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user_list()
    {
        return $this->list(Replay::userReplay(), 'Users Replays');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function gosu_list()
    {
        return $this->list(Replay::gosuReplay(), 'Gosu Replay');
    }

    /**
     * @param Replay $replay
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function list(Replay $replay, $title)
    {
        $data = $this->getReplay($replay)
            ->orderBy('created_at')
            ->paginate(20);

        return view('replay.list')->with(['replays' => $data, 'title'=>$title]);
    }

    /**
     * @param Replay $replay
     * @return Replay|\Illuminate\Database\Eloquent\Builder
     */
    private function getReplay(Replay $replay)
    {
        return $replay->with(User::getUserWithReputationQuery())
                ->withCount('comments', 'positive','negative')
                ->with('type','user', 'map','first_country','second_country');
    }

    /**
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('replay.create')->with(['types' => ReplayType::all(), 'maps' => ReplayMap::all(), 'countries' => Country::all(), 'races' => Replay::$races]);
    }

    /**
     * @param ReplayStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReplayStoreRequest $request)
    {
        $replay_data = $request->validated();

        $path = str_replace('public', '/storage',$replay_data['replay']->store('public/replays'));

        $file = File::create([
            'user_id' => Auth::id(),
            'title' => 'Replay '.$request->get('title'),
            'link' => $path
        ]);

        $replay_data['file_id'] = $file->id;
        $replay_data['user_id'] = Auth::id();

        unset($replay_data['replay']);

        $replay = Replay::create($replay_data);

        return redirect()->route('replay.get', ['id' => $replay->id]);
    }


    /**
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
                $path = str_replace('public', '/storage',$replay_data['replay']->store('public/replays'));

                $file = File::create([
                    'user_id' => Auth::id(),
                    'title' => 'Replay '.$request->get('title'),
                    'link' => $path
                ]);

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
     * @param int $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserReplay($user_id = 0)
    {
        if (!$user_id){
            $user_id = Auth::id();
        }

        return $this->list(Replay::userReplay()->where('user_id',$user_id), 'User Replay');
    }

    /**
     * @param int $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserGosuReplay($user_id = 0)
    {
        if (!$user_id){
            $user_id = Auth::id();
        }

        return $this->list(Replay::gosuReplay()->where('user_id',$user_id), 'Gosu Replay');
    }

    /**
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserReplayByType($type)
    {
        $type = ReplayType::where('name', $type)->first();

        if(!$type){
            return abort(404);
        }

        return $this->list(Replay::userReplay()->where('type_id',$type->id), 'User Replay '.$type);
    }

    /**
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserGosuReplayByType($type)
    {
        $type = ReplayType::where('name', $type)->first();

        if(!$type){
            return abort(404);
        }

        return $this->list(Replay::gosuReplay()->where('user_id',$type->id), 'Gosu Replay '.$type);
    }
}
