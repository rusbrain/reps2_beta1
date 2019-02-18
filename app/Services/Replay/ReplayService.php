<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 9:59
 */

namespace App\Services\Replay;

use App\File;
use App\Http\Controllers\ReplayController;
use App\Http\Requests\ReplaySearchRequest;
use App\Http\Requests\ReplayStoreRequest;
use App\Replay;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ReplayService
{
    public static function listReplay(ReplaySearchRequest $request, ReplayController $object)
    {
        $method = $object->method_get;
        $query = Replay::$method();
        $request_data = $request->validated();

        foreach ($request_data as $key=>$datum){
            if (is_null($datum)){
                unset($request_data[$key]);
            }
        }

        if ($request_data){
            foreach ($request_data as $key=>$request_datum) {
                if ($key == 'text'){
                    $query->where(function ($q) use ($request_datum){
                        $q->where('title', 'like', "%$request_datum%")
                            ->orWhere('content', 'like', "%$request_datum%")
                            ->orWhere('championship', 'like', "%$request_datum%");
                    });
                }elseif($key == 'sort_by'){
                    $query->orderBy($request_datum, 'desc');
                }else{
                    $query->where($key, $request_datum);
                }
            }
        }

        return $query;
    }

    /**
     * get Replay query
     *
     * @param \Illuminate\Database\Eloquent\Builder $replay
     * @return Replay|\Illuminate\Database\Eloquent\Builder
     */
    public static function getReplayQuery(Builder $replay)
    {
        return $replay->with(User::getUserWithReputationQuery())
            ->with(['user'=> function($q){
                $q->withTrashed();
            }])
            ->withCount( 'positive', 'negative', 'comments')
            ->with('user')
            ->with(['user_rating' => function($query){
                $query->where('user_id', Auth::id());
            }]);
    }

    /**
     *  get Replay query
     *
     * @param $id
     * @return mixed
     */
    public static function getReplay($id)
    {
        return Replay::where('id', $id)
            ->with(User::getUserWithReputationQuery())
            ->with(['user'=> function($q){
                $q->withTrashed();
            }])
            ->first();
    }

    /**
     * @param $query
     * @return mixed
     */
    public static function replayWithPagination($query)
    {
        return $query
            ->with('map')
            ->withCount( 'positive', 'negative', 'comments')
            ->orderBy('created_at')
            ->paginate(20);
    }

    /**
     * @param ReplayStoreRequest $request
     * @return mixed
     */
    public static function store(ReplayStoreRequest $request)
    {
        $replay_data = $request->validated();

        $title = 'Replay '.$request->has('title')?$request->get('title'):'';
        $file = File::storeFile($replay_data['replay'], 'replays', $title);

        $replay_data['file_id'] = $file->id;
        $replay_data['user_id'] = Auth::id();

        unset($replay_data['replay']);

        $replay = Replay::create($replay_data);

        return $replay->id;
    }

    /**
     * @param Replay $replay
     * @return mixed
     */
    public static function download(Replay $replay)
    {
        $file = $replay->file()->first();

        $replay->downloaded = $replay->downloaded+1;

        $replay->save();

        return $file->link;
    }

    /**
     * @param Replay $replay
     * @throws \Exception
     */
    public static function destroy(Replay $replay)
    {
        $file = $replay->file()->first();
        File::removeFile($file->id);

        $replay->user_rating()->delete();
        $replay->comments()->delete();
        $replay->delete();
    }

    /**
     * get Replay view list
     *
     * @param $query
     * @param $title
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function getList($query, $title)
    {
        $data = ReplayService::replayWithPagination(ReplayService::getReplayQuery($query));
        return view('replay.list')->with(['replays' => $data, 'title' => $title]);
    }
}