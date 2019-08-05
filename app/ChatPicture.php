<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\{
    Model
};
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ChatPictureSearchAdminRequest;
use App\Services\Chat\ChatPicturesService;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $file_id
 * @property string  $comment
 *
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */

class ChatPicture extends Model
{
    use Notifiable;
    
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'chat_pictures';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'file_id',
        'comment',
        'category_id',
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
    public function category()
    {
        return $this->belongsTo('App\ChatPictureCategory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File');
    }

    public static function getpictureById($id) {
        return ChatPicture::where('id', $id)
        ->with('user', 'file')
        ->first();
    }

    /**
     * @param ChatPictureSearchAdminRequest $request
     * @return mixed
     */
    public static function getPictures(ChatPictureSearchAdminRequest $request)
    {
        return ChatPicturesService::search($request)
            ->with('file', 'user', 'category')->orderBy('updated_at', 'Desc')->paginate(20);
    }

}
