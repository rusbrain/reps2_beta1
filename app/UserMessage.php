<?php

namespace App;

use App\Traits\ModelRelations\UserMessageRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserMessage extends Model
{
    use UserMessageRelation;
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
        'user_id',
        'dialogue_id',
        'message',
        'is_read',
    ];

    /**
     * Save new message
     *
     * @param Request $request
     * @param $dialogue_id
     * @return mixed
     */
    public static function createMessage(Request $request, $dialogue_id)
    {
        return UserMessage::create([
            'user_id'       => Auth::id(),
            'dialogue_id'   => $dialogue_id,
            'message'       => $request->get('message'),
        ]);
    }
}
