<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.10.18
 * Time: 12:50
 */

namespace App\Services;

use App\{Country, ForumTopic, GameVersion, Replay, ReplayMap, UserMessage, UserRole};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminViewHelper
{
    protected $menu_name;
    protected $notifications;
    protected $role;
    protected $countries;
    protected $user_role;
    protected $maps;
    protected $game_versions;

    /**
     * Get URI name for admin panel
     *
     * @return string
     */
    public function getMenuName()
    {
        $this->menu_name = $this->menu_name??str_ireplace('admin_panel/','',Request::capture()->path());

        return $this->menu_name;
    }

    public function getNotifications()
    {
        $new_user_message_q = UserMessage::whereHas('dialogue.users', function ($query){
            $query->where('users.id', Auth::id());
        })->where('user_id', '<>', Auth::id())->where('is_read',0);

        $new_user_message_q2 = clone $new_user_message_q;

        $new_messages_count = $new_user_message_q2->count();

        $new_messages       = $new_user_message_q->limit(5)->with('sender.avatar')->get();
        $new_topics         = ForumTopic::where('approved',0)->where(function ($q){
            $q->whereNull('start_on')
                ->orWhere('start_on','<=', Carbon::now()->format('Y-m-d'));
        })->count();
        $new_gosu_replays   = Replay::gosuReplay()->where('approved',0)->count();
        $new_user_replays   = Replay::userReplay()->where('approved',0)->count();

        $this->notifications = $this->notifications??[
                'new_messages_count'=> $new_messages_count,
                'new_messages'      => $new_messages,
                'new_topics'        => $new_topics,
                'new_gosu_replays'  => $new_gosu_replays,
                'new_user_replays'  => $new_user_replays,
                'all_notification'  => $new_topics + $new_gosu_replays + $new_user_replays,
            ];

        return $this->notifications;
    }

    /**
     * User is admin
     *
     * @return bool
     */
    public function admin()
    {
        $this->role = $this->role??(Auth::user()->role?(Auth::user()->role->name == 'admin'):false);
        return $this->role;
    }

    /**
     * @return Country[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCountries()
    {
        $this->countries = $this->countries??Country::all();
        return $this->countries;
    }

    /**
     * @return Country[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUserRole()
    {
        $this->user_role = $this->user_role??UserRole::all();
        return $this->user_role;
    }

    /**
     * @return ReplayMap[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMaps()
    {
        $this->maps = $this->maps??ReplayMap::all();
        return $this->maps;
    }

    /**
     * @return GameVersion[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getGameVersions()
    {
        $this->game_versions = $this->game_versions??GameVersion::all();
        return $this->game_versions;
    }
}