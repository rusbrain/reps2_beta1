<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.10.18
 * Time: 12:50
 */

namespace App\Services;

use App\Banner;
use App\Country;
use App\File;
use App\ForumSection;
use App\ForumTopic;
use App\GameVersion;
use App\InterviewQuestion;
use App\Replay;
use App\ReplayMap;
use App\ReplayType;
use App\User;
use App\UserGallery;
use App\UserMessage;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GeneralViewHelper
{
    protected $last_forum;
    protected $last_forum_home;
    protected $last_gosu_replay;
    protected $last_user_replay;
    protected $countries;
    protected $user_roles;
    protected $bd_users;
    protected $all_sections;
    protected $replay_type;
    protected $general_sections;
    protected $replay_maps;
    protected $banner;
    protected $question;
    protected $new_users;
    protected $game_version;

    /**
     * Get random user gallery images
     *
     * @return array
     */
    public function getRandomImg()
    {
        $data_img = UserGallery::orderBy('created_at', 'desc')->limit(5000)->get(['id'])->toArray();
        $random_img_ids = $data_img?array_rand($data_img,(count($data_img)>4?4:count($data_img))):[];
        $random_img = [];
        foreach ($random_img_ids as $item){
            $data = $data_img[$item]['id'];
            $random_img[] = $data;
        }
        $random_img = UserGallery::whereIn('id', $random_img)->with('file')->get()->toArray();

        return $random_img;
    }

    /**
     * Get pandom question for user
     *
     * @return mixed
     */
    public function getRandomQuestion()
    {
        $this->question = $this->question??InterviewQuestion::getRandomQuestion();
        return  $this->question;
    }

    /**
     * @return mixed
     */
    public function getLastForum()
    {
        $this->last_forum =  $this->last_forum??ForumSection::general_active()->with(['topics' =>function($query){
                $query->with('user')->orderBy('created_at', 'desc')->limit(5);
            }])->get();

        return $this->last_forum;
    }

    /**
     * @return mixed
     */
    public function getLastGosuReplay()
    {
        if(!$this->last_gosu_replay){
            $this->last_gosu_replay=Replay::gosuReplay()->orderBy('created_at', 'desc')->limit(5)->get();
            $this->last_gosu_replay->load('user', 'map', 'game_version');
        }

        return $this->last_gosu_replay;
    }

    /**
     * @return mixed
     */
    public function getLastUserReplay()
    {
        $this->last_user_replay = $this->last_user_replay??Replay::userReplay()->with('user')->orderBy('created_at', 'desc')->limit(5)->get();
        return $this->last_user_replay;
    }

    /**
     * @return int
     */
    public function getNewUserMessage()
    {
        $new_user_message = 0;

        if (Auth::user()){
            $new_user_message = UserMessage::where('user_recipient_id', Auth::id())->where('is_read',0)->count();
        }

        return $new_user_message;
    }

    /**
     * @return mixed
     */
    public function getNewUsers()
    {
        $new_users = $new_users??User::where('is_ban',0)->orderBy('created_at', 'desc')->limit(10)->get();
        return  $new_users;
    }

    /**
     * @return Country[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCountries()
    {
        if(!$this->countries){
            $countries = Country::all();

            foreach ($countries as $country){
                $this->countries[$country->id] = $country;
            }
        }

        return $this->countries;
    }

    /**
     * @return UserRole[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUsersRole()
    {
        $this->user_roles = $this->user_roles??UserRole::all();
        return $this->user_roles;
    }

    /**
     * @return mixed
     */
    public function getBirthdayUsers()
    {
        $this->bd_users = $this->bd_users??User::where('birthday', 'like',"%".Carbon::now()->format('m-d'))->get();
        return $this->bd_users;
    }

    /**
     * @return ForumSection[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllForumSections()
    {
        $this->all_sections = $this->all_sections??ForumSection::with(['topics' =>function($q){
            $q->orderBy('created_at', 'desc')->limit(5);
            }])->orderBy('position')->get();
        return $this->all_sections;
    }

    /**
     * @return ReplayType[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getReplayTypes()
    {
        if(!$this->replay_type){
            $types = ReplayType::all();

            foreach ($types as $type){
                $this->replay_type[$type->id] = $type;
            }
        }

        return $this->replay_type;
    }

    /**
     * @return mixed
     */
    public function getGeneralSectionsForum()
    {
        $this->general_sections = $this->general_sections??ForumSection::where('is_general', 1)->get();
        return $this->general_sections;
    }

    /**
     * @return mixed
     */
    public function getRandomBanner()
    {
        $this->banner = $this->banner??Banner::getRandomBanner();
        return $this->banner;
    }

    public function getTopReplayAll()
    {

    }

    public function getTopReplayWeek()
    {

    }

    public function getTopReplayMonth()
    {

    }

    /**
     * @return mixed
     */
    public function getLastForumHome()
    {
        $this->last_forum_home = $this->last_forum_home??ForumTopic::whereHas('section', function($query){
                $query->where('is_active',1)->where('is_general',1);
            })
                ->with('section', 'user', 'preview_image', 'icon')
                ->limit(5)->get();

        return $this->last_forum_home;
    }

    /**
     * Get Replay Maps
     *
     * @return ReplayMap[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getReplayMaps()
    {
        if(!$this->replay_maps){
            $types = ReplayMap::all();

            foreach ($types as $type){
                $this->replay_maps[$type->id] = $type;
            }
        }

        return $this->replay_maps;
    }

    /**
     * Get Replay Maps
     *
     * @return ReplayMap[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getGAmeVersion()
    {
        if(!$this->game_version){
            $types = GameVersion::all();

            foreach ($types as $type){
                $this->game_version[$type->id] = $type;
            }
        }

        return $this->game_version;
    }

    /**
     * @param $user
     * @return bool
     */
    public function isOnline($user)
    {
        $time = (Carbon::now()->getTimestamp() - Carbon::parse($user->activity_at)->getTimestamp())/60;

        return $time <= 15;
    }
}