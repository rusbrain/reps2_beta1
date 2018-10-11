<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserMessage extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='user_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_sender_id',
        'user_recipient_id',
        'message',
        'is_read',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'user_sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo('App\User', 'user_recipient_id');
    }

    /**
     * Loaded user messages with pagination/Get user messages
     *
     * @param $user_id
     * @return mixed
     */
    public static function loadMessages($user_id)
    {
        $messages = UserMessage::where(function ($query) use ($user_id){
            $query->where('user_sender_id', Auth::id())->where('user_recipient_id', $user_id);
        })
            ->orWhere(function ($query) use ($user_id){
                $query->where('user_sender_id', $user_id)->where('user_recipient_id', Auth::id());
            })
            ->with('sender.avatar', 'recipient.avatar')->orderBy('id', 'desc')->paginate(20);

        return $messages;
    }

    /**
     * Save new message
     *
     * @param Request $request
     * @param $user_id
     * @return mixed
     */
    public static function createMessage(Request $request, $user_id)
    {
        return UserMessage::create([
            'user_sender_id'    => Auth::id(),
            'user_recipient_id' => $user_id,
            'message'           => $request->get('message'),
        ]);
    }
}
