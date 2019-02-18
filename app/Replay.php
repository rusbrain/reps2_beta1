<?php

namespace App;

use App\Http\Requests\ReplaySearchAdminRequest;
use App\Observers\ReplayPointsObserver;
use App\Traits\ModelRelations\ReplayRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class Replay extends Model
{
    use Notifiable, ReplayRelation;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created'   => ReplayPointsObserver::class,
        'deleted'   => ReplayPointsObserver::class,
        'restored'  => ReplayPointsObserver::class,
    ];

    /**
     * @var array
     */
    public static $races = [
        1 => 'All',
        2 => 'Z',
        3 => 'T',
        4 => 'P',
    ];

    public static $creating_rates = [
        1 => '7',
        2 => '8',
        3 => '9',
        4 => '10',
        5 => 'Cool',
        6 => 'Best'
    ];

    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'replays';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_replay', 'type_id','title', 'content', 'map_id', 'file_id',
        'game_version_id', 'championship', 'first_country_id', 'second_country_id',
        'first_matchup', 'second_matchup', 'rating', 'user_rating', 'first_race',
        'second_race', 'first_location', 'second_location', 'creating_rate' ,'negative_count',
        'positive_count', 'comments_count', 'downloaded', 'length', 'approved'];

    /**
     * @param $rating
     * @param $replay_id
     */
    public static function updateRating($rating, $replay_id)
    {
        \DB::update('update replays set rating = rating + (?) where id = ?', [$rating, $replay_id]);
    }

    /**
     * Update value of user rating
     *
     * @param $replay_id
     */
    public static function updateUserRating($replay_id)
    {
        $count = ReplayUserRating::where('replay_id',[$replay_id])->count();
        $rating = $count?(ReplayUserRating::where('replay_id',[$replay_id])->sum('rating')/$count):0;

        Replay::where('id', $replay_id)->update(['user_rating'=>$rating]);
    }

    /**
     * Get query users replay
     *
     * @return mixed
     */
    public static function userReplay()
    {
        return Replay::where('user_replay', 1);
    }

    /**
     * Get query for gosu replay
     *
     * @return mixed
     */
    public static function gosuReplay()
    {
        return Replay::where('user_replay', 0);
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
     * @param ReplaySearchAdminRequest $request
     * @return mixed
     */
    public static function getReplay(ReplaySearchAdminRequest $request)
    {
        return self::search($request,Replay::withCount('user_rating'))
            ->with('user',  'file', 'first_country', 'second_country', 'type', 'map')->withCount( 'positive', 'negative', 'comments')->paginate(50);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getreplayById($id)
    {
        return Replay::where('id', $id)
            ->withCount( 'user_rating')
            ->withCount( 'positive', 'negative', 'comments')
            ->with('user.avatar', 'file', 'game_version')->first();
    }
}