<?php

namespace App;

use App\Traits\ModelRelations\DialogueRelation;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

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
     * Get User Dialog content
     *
     * @param $dialog_id
     * @return mixed
     */
    public static function getUserDialogueContent($dialog_id)
    {
        $dialogues = Dialogue::find($dialog_id)->messages()->orderBy('created_at', 'desc')->with('sender.avatar')->paginate(10);
        $user_id = \Auth::id();
        Dialogue::find($dialog_id)->messages()->where('user_id','<>',$user_id)->update(['is_read'=>1]);
        return $dialogues;
    }
}