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
 * @property string  $name
 * @property string  $comment
 */

class ChatPictureCategory extends Model
{
    use Notifiable;
    
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'chat_pictures_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'comment',
    ];    

    public static function getCateById($id) {
        return ChatPictureCategory::where('id', $id)
        ->first();
    }
}
