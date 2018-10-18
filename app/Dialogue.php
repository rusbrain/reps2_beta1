<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Dialogue extends Model
{
    use SoftDeletes;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'dialogue_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\UserMessage','dialogue_id');
    }

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
        $dialogues = Dialogue::find($dialog_id)->messages()->with('sender.avatar')->paginate(10);

        Dialogue::find($dialog_id)->messages()->update(['is_read'=>1]);

         return $dialogues;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function getDialogUser($user_id)
    {
        $dialogue = Dialogue::whereHas('users',function ($query) use ($user_id){
            $query->where('users.id', $user_id);
        })->whereHas('users',function ($query) use ($user_id){
            $query->where('users.id', Auth::id());
        })->first();

        if(!$dialogue){
            $dialogue = new Dialogue();
            $dialogue->save();

            $dialogue->users()->attach([$user_id, Auth::id()]);
        }

        return $dialogue;
    }
}