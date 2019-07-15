<?php

namespace App;

use App\Contracts\CommentContainerInterface;
use App\Http\Requests\ReplaySearchAdminRequest;
use App\Observers\ReplayPointsObserver;
use App\Services\Replay\ReplayService;
use App\Traits\ModelRelations\ReplayRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $user_replay
 * @property integer $downloaded
 * @property integer $file_id
 * @property string $title
 * @property string $content
 * @property Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Replay extends Model implements CommentContainerInterface
{
    use Notifiable, ReplayRelation;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ReplayPointsObserver::class,
        'deleted' => ReplayPointsObserver::class,
        'restored' => ReplayPointsObserver::class,
    ];

    const REPLAY_NOT_APPROVED  = 0;
    const REPLAY_APPROVED      = 1;

    /**
     * @var array
     */
    public static $races = [
        1 => 'All',
        2 => 'Z',
        3 => 'T',
        4 => 'P',
    ];
    public static $races_full = [
         'All' => 'Random',
         'Z' => 'Zerg',
         'T' => 'Terran',
         'P' => 'Protoss',
    ];

    public static $race_icons = [
        'All' => 'random.png',
        'Z' => 'zerg.gif',
        'T' => 'terran.gif',
        'P' => 'protoss.gif',
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
        'user_id',
        'user_replay',
        'type_id',
        'title',
        'content',
        'map_id',
        'file_id',
        'first_country_id',
        'second_country_id',
        'first_matchup',
        'second_matchup',
        'rating',//
        'user_rating',
        'first_race',
        'second_race',
        'first_location',
        'second_location',
        'negative_count',
        'positive_count',
        'comments_count',
        'downloaded',
        // 'length',
        'approved',
        'video_iframe'
    ];

    /**
     * @param $rating
     * @param $replay_id
     */
    public static function updateRating($rating, $replay_id)
    {
        \DB::update('update replays set rating = rating + (?) where id = ?', [$rating, $replay_id]);
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
     * @param ReplaySearchAdminRequest $request
     * @return mixed
     */
    public static function getReplay(ReplaySearchAdminRequest $request)
    {
        return ReplayService::search($request, Replay::withCount('user_rating'))
            ->with('user', 'file', 'first_country', 'second_country', 'type', 'map')->withCount('positive', 'negative',
                'comments')->paginate(50);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getreplayById($id)
    {
        return Replay::where('id', $id)
            ->withCount('user_rating')
            ->withCount('positive', 'negative', 'comments')
            ->with('user.avatar', 'file', 'game_version')->first();
    }

    /**
     * get last five replays
     *
     * @param int $limit
     * @return $this
     */
    public static function getLastReplays($limit = 5)
    {

        return DB::table((new self)->getTable())
            ->select(DB::raw("id, created_at, 'replay' AS 'type'"))
            ->where('approved', 1)
            ->orderBy('created_at', 'desc')
            ->limit($limit);
    }

    /**
     * Get replays by ids
     *
     * @param array $ids
     * @return mixed
     */
    public static function getReplayByIds(array $ids)
    {
        return Replay::whereIn('id', $ids)->get();
    }

    /**
     * Get five populates replays
     *
     * @param $limit
     * @return $this
     */
    public static function getTopReplays($limit)
    {
        return DB::table((new self())->getTable())
            ->select(DB::raw("id, rating, 'replay' AS 'type'"))
            ->where('approved', 1)
            ->orderBy('rating','DESC')
            ->limit($limit);
    }

    public static function isApproved($status)
    {
        return $status == self::REPLAY_APPROVED ? true : false;
    }

    public function getRouteConfig()
    {
        return ['replay.get', ['id' => $this->id]];
    }

    public function getTitle()
    {
        return $this->title;
    }


}
