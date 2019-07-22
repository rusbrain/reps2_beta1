<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\{
    Model
};
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $file_id
 * @property string  $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */

class ChatSmile extends Model
{
    use  Notifiable;
    
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'chat_smiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'file_id',
        'comment',
        'charactor'
    ];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File');
    }

    public static function getsmileById($id) {
        return ChatSmile::where('id', $id)
        ->with('user', 'file')
        ->first();
    }

}
