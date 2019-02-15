<?php

namespace App;

use App\Traits\ModelRelations\DialogueRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Dialogue extends Model
{
    use SoftDeletes, DialogueRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='dialogues';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get User Dialogs
     *
     * @param $user_id
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
     * Get User Dialog content
     *
     * @param $user_id
     * @return mixed
     */
    public static function getUserDialogueContent($dialog_id)
    {
        $dialogues = Dialogue::find($dialog_id)->messages()->orderBy('created_at', 'desc')->with('sender.avatar')->paginate(10);

        Dialogue::find($dialog_id)->messages()->update(['is_read'=>1]);

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