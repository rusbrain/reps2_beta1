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
    protected $user_gallery;
    protected static $instance;

    public function __construct()
    {
        if (!self::$instance){
            self::$instance = $this;
        }
    }

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
        self::$instance->question = self::$instance->question??InterviewQuestion::getRandomQuestion();
        return  self::$instance->question;
    }

    /**
     * @return mixed
     */
    public function getLastForum()
    {
        if(!self::$instance->last_forum){
            if(!self::$instance->all_sections){
                self::$instance->getAllForumSections();
            }

            self::$instance->last_forum = self::$instance->all_sections->where('is_general', 1);
        }

        return self::$instance->last_forum;
    }

    /**
     * @return mixed
     */
    public function getLastGosuReplay()
    {
        if(!self::$instance->last_gosu_replay){
            self::$instance->last_gosu_replay=Replay::gosuReplay()->orderBy('created_at', 'desc')->limit(5)->get();
            self::$instance->last_gosu_replay->load('user', 'map', 'game_version');
        }

        return self::$instance->last_gosu_replay;
    }

    /**
     * @return mixed
     */
    public function getLastUserReplay()
    {
        self::$instance->last_user_replay = self::$instance->last_user_replay??Replay::userReplay()->with('user')->orderBy('created_at', 'desc')->limit(5)->get();
        return self::$instance->last_user_replay;
    }

    /**
     * @return int
     */
    public function getNewUserMessage()
    {
        $new_user_message = 0;

        if (Auth::user()){
            $new_user_message = UserMessage::whereHas('dialogue.users', function ($query){
                $query->where('users.id', Auth::id());
            })->where('user_id', '<>', Auth::id())->where('is_read',0)->count();
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
        if(!self::$instance->countries){
            $countries = Country::all();

            foreach ($countries as $country){
                self::$instance->countries[$country->id] = $country;
            }
        }

        return self::$instance->countries;
    }

    /**
     * @return UserRole[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUsersRole()
    {
        self::$instance->user_roles = self::$instance->user_roles??UserRole::all();
        return self::$instance->user_roles;
    }

    /**
     * @return mixed
     */
    public function getBirthdayUsers()
    {
        self::$instance->bd_users = self::$instance->bd_users??User::where('birthday', 'like',"%".Carbon::now()->format('m-d'))->get();
        return self::$instance->bd_users;
    }

    /**
     * @return ForumSection[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllForumSections()
    {
        if(!$this->all_sections){
            $all_sections = ForumSection::active()->get();

            foreach ($all_sections as $key=>$section){
                $all_sections[$key]->topics = ForumTopic::where('section_id',$section->id)->orderBy('created_at', 'desc')->limit(5)->get();
            }

            $this->all_sections = $all_sections;
        }

        return self::$instance->all_sections;
    }

    /**
     * @return ReplayType[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getReplayTypes()
    {
        if(!self::$instance->replay_type){
            $types = ReplayType::all();

            foreach ($types as $type){
                self::$instance->replay_type[$type->id] = $type;
            }
        }

        return self::$instance->replay_type;
    }

    /**
     * @return mixed
     */
    public function getGeneralSectionsForum()
    {
        if(!self::$instance->general_sections){
            if(!self::$instance->all_sections){
                self::$instance->getAllForumSections();
            }

            self::$instance->general_sections = self::$instance->all_sections->where('is_general', 1);
        }

        return self::$instance->general_sections;
    }

    /**
     * @return mixed
     */
    public function getRandomBanner()
    {
        self::$instance->banner = self::$instance->banner??Banner::getRandomBanner();
        return self::$instance->banner;
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
        self::$instance->last_forum_home = self::$instance->last_forum_home??ForumTopic::whereHas('section', function($query){
                $query->where('is_active',1)->where('is_general',1);
            })
                ->with('section', 'user', 'preview_image', 'icon')
                ->limit(5)->get();

        return self::$instance->last_forum_home;
    }

    /**
     * Get Replay Maps
     *
     * @return ReplayMap[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getReplayMaps()
    {
        if(!self::$instance->replay_maps){
            $types = ReplayMap::all();

            foreach ($types as $type){
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
        if(!self::$instance->game_version){
            $types = GameVersion::all();

            foreach ($types as $type){
                self::$instance->game_version[$type->id] = $type;
            }
        }

        return self::$instance->game_version;
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

    /**
     * @param $user_id
     * @return mixed
     */
    public function getUserGallery($user_id)
    {
        self::$instance->user_gallery = self::$instance->user_gallery??UserGallery::where('user_id', $user_id)->with('file')->get();
        return self::$instance->user_gallery;
    }
}