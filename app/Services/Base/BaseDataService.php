<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 11:34
 */

namespace App\Services\Base;

use App\{ForumTopic, Replay, User, Banner, StreamHeader, Stream};
use App\Http\Requests\QuickEmailRequest;
use App\Mail\QuickEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BaseDataService
{
    /**
     * @return array
     */
    public static function getAdminBaseData()
    {
        $topic_count = ForumTopic::where(function ($q){
            $q->whereNull('start_on')
                ->orWhere('start_on','<=', Carbon::now()->format('Y-m-d'));
        })->count();

        $gosu_replay_count = Replay::gosuReplay()->count();
        $user_replay_count = Replay::userReplay()->count();
        $user_count = User::count();

        return [
            'topic_count'       => $topic_count,
            'gosu_replay_count' => $gosu_replay_count,
            'user_replay_count' => $user_replay_count,
            'user_count'        => $user_count,
        ];
    }

    /**
     * @param QuickEmailRequest $request
     */
    public static function sendQuickEmail(QuickEmailRequest $request)
    {
        Mail::send(new QuickEmail($request->get('content'), $request->get('subject'), $request->get('emailto')));
    }

    /**
     * @param $table
     * @param $pagination
     * @param string $pop_up
     * @return array
     */
    public static function getPaginationData($table, $pagination, $pop_up = '')
    {
       return ['table' => $table, 'pagination' => $pagination, 'pop_up' => $pop_up];
    }

    /**
     * @return mixed
     */
    public static function getRandomBanner()
    {
        $banners_id = Banner::where('is_active',1)->has('file')->get(['id']);

        $ids = [];
        foreach ($banners_id as $banner){
            $ids[] = $banner->id;
        }
        $id = array_rand($ids);

        return Banner::where('id', $ids[$id])->with('file')->first();
    }

    public static function getActiveBanners()
    {
        return Banner::where('is_active',1)->has('file')->with('file')->get();
    }

    public static function getStreamHeader()
    {
        return StreamHeader::orderBy('updated_at', 'Desc')->first();
    }

    public static function streams_list() {
        return Stream::where('approved', 1)->orderBy('updated_at', 'Desc')->limit(20)->get();
    }
}