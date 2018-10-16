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
        'user_id',
        'dialogue_id',
        'message',
        'is_read',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dialogue()
    {
        return $this->belongsTo('App\Dialogue', 'dialogue_id');
    }
}
