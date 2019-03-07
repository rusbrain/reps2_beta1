<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 9:59
 */

namespace App\Services\Replay;

use App\{File, Replay, Services\Base\UserViewService, User};
use App\Http\Controllers\ReplayController;
use App\Http\Requests\{ReplaySearchAdminRequest, ReplaySearchRequest, ReplayStoreRequest};
use App\Services\Base\FileService;
use App\Services\Rating\RatingService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplayService
{
    /**
     * @param ReplaySearchRequest $request
     * @param ReplayController $object
     * @return mixed
     */
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
     * get Replay data list with pagination
     *
     * @param $query
     * @param $title
     * @return array
     */
    public static function getList($query, $title)
    {
        $data = ReplayService::replayWithPagination(ReplayService::getReplayQuery($query));
        return ['replays' => UserViewService::getReplay($data), 'pagination' => UserViewService::getPagination($data)];
    }

    /**
     * @param ReplaySearchAdminRequest $request
     * @param $user_id
     * @return array
     */
    public static function getReplayByUser(ReplaySearchAdminRequest $request, $user_id)
    {
        $user = User::find($user_id);
        $replays = $data = ReplayService::search($request,Replay::where('user_id', $user_id))->count();
        $request_data = $request->validated();
        $request_data['user_id'] = $user_id;
        return ['replay_count' => $replays, 'title' => "Replays $user->name", 'user' => $user, 'request_data' => $request_data];
    }

    /**
     * @param $replay_id
     */
    public static function remove($replay_id)
    {
        $replay = Replay::find($replay_id);
        $user_id = $replay->user_id;

        FileService::removeFile($replay->file_id);
        $replay->positive()->delete();
        $replay->negative()->delete();
        $replay->user_rating()->delete();
        $replay->comments()->delete();

        Replay::where('id', $replay_id)->delete();
        RatingService::recountRating($user_id);
    }



    /**
     * @param Request $request
     * @param Replay $replay
     * @return bool|void
     */
    public static function updateReplay(Request $request, Replay $replay)
    {
        $replay_data = $request->validated();

        if($request->has('replay')){
            FileService::removeFile($replay->file_id);

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

        if ($request->has('creating_rate') && $request->get('creating_rate') == ''){
            $replay_data['creating_rate'] = '';
        }

        if (!$request->has('approved')){
            $replay_data['approved'] = "0";
        }

        if ($request->has('length') && $request->get('length') == ''){
            $replay_data['length'] = '00:00:00';
        }

        Replay::where('id', $replay->id)->update($replay_data);
    }

    /**
     * @param Request $request
     * @param bool $query
     * @return bool
     */
    public static function search(Request $request, $query = false)
    {
        if (!$query){
            $query = Replay::where('id', '>', 0);
        }

        $request_data = $request->validated();

        if(isset($request_data['search']) && $request_data['search']){
            $query->where(function ($q) use ($request_data){
                $q->where('id', 'like', "%{$request_data['search']}%")
                    ->orWhere('title', 'like', "%{$request_data['search']}%")
                    ->orWhere('championship', 'like', "%{$request_data['search']}%");
            });
        }

        if(isset($request_data['map']) && $request_data['map']){
            $query->where('map_id', $request_data['map']);
        }

        if(isset($request_data['type']) && $request_data['type']){
            $query->where('type_id', $request_data['type']);
        }

        if(isset($request_data['users']) && $request_data['users'] !== null){
            $query->where('user_replay', $request_data['users']);
        }

        if(isset($request_data['approved']) && $request_data['approved'] !== null){
            $query->where('approved', $request_data['approved']);
        }

        if(isset($request_data['country']) && $request_data['country']){
            $query->where(function ($q) use ($request_data){
                $q->where('first_country_id', $request_data['country'])
                    ->orWhere('second_country_id', $request_data['country']);
            });
        }

        if(isset($request_data['race']) && $request_data['race']){
            $query->where(function ($q) use ($request_data){
                $q->where('first_race', $request_data['race'])
                    ->orWhere('second_race', $request_data['race']);
            });
        }

        if(isset($request_data['sort']) && $request_data['sort']){
            $query->orderBy($request_data['sort']);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if (isset($request_data['user_id']) && $request_data['user_id']){
            $query->where('user_id', $request['user_id']);
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public static function getLastGosuReplay() //TODO:remove
    {
            $last_gosu_replay = Replay::gosuReplay()->where('approved', 1)->orderBy('created_at',
                'desc')->limit(5)->get();
            $last_gosu_replay->load('map');
        return $last_gosu_replay->load('map');
    }
}