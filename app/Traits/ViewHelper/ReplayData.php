<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.19
 * Time: 12:15
 */

namespace App\Traits\ViewHelper;

use App\{
    GameVersion, Replay, ReplayMap, ReplayType, ReplayUserRating, Services\Replay\ReplayService
};

trait ReplayData
{
    /**
     * @return array
     */
    public function getReplaySortBy()
    {
        return [
            'game_version_id' => 'Версия',
            'rating' => 'Рейтинг',
            'user_rating' => 'Юзер Рейтинг',
            'length' => 'Продолжительность',
            'title' => 'Название',
            'created_at' => 'Дата создания',
            'type_id' => 'Тип игры'
        ];
    }

    /**
     * @return mixed
     */
    public function getLastGosuReplay()
    {
        if (!self::$instance->last_gosu_replay) {
            self::$instance->last_gosu_replay = ReplayService::getLastGosuReplay(5);
        }
        return self::$instance->last_gosu_replay;
    }

    /**
     * @return mixed
     */
    public function getLastUserReplay()
    {
        self::$instance->last_user_replay = self::$instance->last_user_replay ?? Replay::userReplay()->where('approved',
                1)->orderBy('created_at', 'desc')->limit(5)->get();
        return self::$instance->last_user_replay;
    }

    /**
     * @return ReplayType[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getReplayTypes()
    {
        if (!self::$instance->replay_type) {
            $types = ReplayType::all();

            foreach ($types as $type) {
                self::$instance->replay_type[$type->id] = $type;
            }
        }
        return self::$instance->replay_type;
    }

    /**
     * Get Replay Maps
     *
     * @return ReplayMap[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getReplayMaps()
    {
        if (!self::$instance->replay_maps) {
            $types = ReplayMap::all();

            foreach ($types as $type) {
                self::$instance->replay_maps[$type->id] = $type;
            }
        }
        return self::$instance->replay_maps;
    }

    /**
     * Get Replay Maps
     *
     * @return ReplayMap[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getGameVersion()
    {
        if (!self::$instance->game_version) {
            $types = GameVersion::all();

            foreach ($types as $type) {
                self::$instance->game_version[$type->id] = $type;
            }
        }

        return self::$instance->game_version;
    }

    /**
     * Checking User's evaluation on scale 1-5 of current Replay
     *
     * @param Replay $replay
     * @return bool
     */
    public function checkUserReplayEvaluation(Replay $replay)
    {
        /**@var ReplayUserRating $evaluation_vote*/
        $evaluation_vote = ReplayUserRating::where('user_id', \Auth::id())->where('replay_id', $replay->id)->first();
        return $evaluation_vote ? $evaluation_vote->rating : false;
    }
}