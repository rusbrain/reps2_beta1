<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.19
 * Time: 11:33
 */

namespace App\Traits\ViewHelper;

use App\{User, UserGallery, UserMessage, UserRole};
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait UserData
{
    /**
     * Gets from OLD reps.ru files
     */
    public function getUserStatus($cs)
    {
        if ($cs < 1000){
            return "Zim";
        } elseif ($cs < 2000){
            return "Fan of Barbie";
        } elseif ($cs < 3000) {
            return "Zagoogli";
        } elseif ($cs < 4000) {
            return "BIG SCV";
        } elseif ($cs < 5000) {
            return "Hasu";
        } elseif ($cs < 6000) {
            return "XaKaC";
        } elseif ($cs < 7000) {
            return "Idra";
        } elseif ($cs < 8000) {
            return "Trener";
        } elseif ($cs < 9000) {
            return "[СО!]";
        } elseif ($cs < 10000) {
            return "SuperHero";
        } elseif ($cs < 15000) {
            return "Gosu";
        } elseif ($cs < 20000) {
            return "IPXZerg";
        } elseif ($cs < 40000) {
            return "Savior";
        } elseif ($cs < 70000) {
            return "Lutshii";
        } elseif ($cs < 100000 ) {
            return "Bonjva";
        } elseif($cs >= 100000) {
            return "Ebanutyi";
        }
    }

    /**
     * @param $user
     * @return bool
     */
    public function isOnline($user)
    {
        $time = (Carbon::now()->getTimestamp() - Carbon::parse($user->activity_at)->getTimestamp()) / 60;

        return $time <= 15;
    }

    /**
     * @return int
     */
    public function getNewUserMessage()
    {
        $new_user_message = 0;

        if (Auth::user()) {
            $new_user_message = UserMessage::whereHas('dialogue.users', function ($query) {
                $query->where('users.id', Auth::id());
            })->where('user_id', '<>', Auth::id())->where('is_read', 0)->count();
        }

        return $new_user_message;
    }

    /**
     * @return mixed
     */
    public function getNewUsers()
    {
        $new_users = $new_users ?? User::where('is_ban', 0)->orderBy('created_at', 'desc')->limit(10)->get();
        return $new_users;
    }

    /**
     * @return UserRole[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUsersRole()
    {
        self::$instance->user_roles = self::$instance->user_roles ?? UserRole::all();
        return self::$instance->user_roles;
    }

    /**
     * @return mixed
     */
    public function getBirthdayUsers()
    {
        self::$instance->bd_users = self::$instance->bd_users ?? User::where('birthday', 'like',
                "%" . Carbon::now()->format('m-d'))->get();
        return self::$instance->bd_users;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getUserGallery($user_id)
    {
        self::$instance->user_gallery = self::$instance->user_gallery ?? UserGallery::where('user_id',
                $user_id)->with('file')->get();
        return self::$instance->user_gallery;
    }
}