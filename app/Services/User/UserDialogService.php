<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.19
 * Time: 9:46
 */

namespace App\Services\User;

use App\Dialogue;
use Illuminate\Support\Facades\Auth;

class UserDialogService
{
    /**
     * Get User Dialogs
     *
     * @return mixed
     */
    public static function getUserDialogues()
    {
        $dialogues = Dialogue::whereHas('users', function ($query){
            $query->where('user_id', Auth::id());
        })->with('messages.sender', 'users.avatar')
            ->withCount(['messages as new_messages' => function($query){
                $query->where('user_id', '<>', Auth::id())
                    ->where('is_read',0);
            }])
            ->paginate(10);

        $dialogues->transform(function ($item)
        {
            $item->senders = $item->users->unique();
            $item->messages_last = $item->messages->max('created_at');
            unset($item->users);
            unset($item->messages);
            return $item;
        });

        return $dialogues;
    }

    /**
     * Get User Dialog List
     *
     * @return mixed
     */
    public static function getUserDialoguesList()
    {
        $dialogues = Dialogue::whereHas('users', function ($query){
            $query->where('user_id', Auth::id());
        })->with('messages.sender', 'users.avatar')
            ->withCount(['messages as new_messages' => function($query){
                $query->where('user_id', '<>', Auth::id())
                    ->where('is_read',0);
            }])
            ->paginate(10);

        $dialogues->transform(function ($item)
        {
            $item->senders = $item->users->unique();
            $item->messages_last = ($item->messages->last());
            unset($item->users);
            //unset($item->messages);
            return $item;
        });

        return $dialogues;
    }

    /**
     * get dialogue by user
     *
     * @param $user_id
     * @return mixed
     */
    public static function getDialogUser($user_id)
    {
        $dialogue = Dialogue::where(function ($q) use ($user_id){
            $q->whereHas('users',function ($query) use ($user_id){
                $query->where('users.id', $user_id);
            })->whereHas('users',function ($query){
                $query->where('users.id', Auth::id());
            });
        })->with('users')->first();

        if(!$dialogue){
            $dialogue = new Dialogue();
            $dialogue->save();

            $dialogue->users()->attach([$user_id, Auth::id()]);
        }

        return $dialogue;
    }
}