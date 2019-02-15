<?php

namespace App;

use App\Traits\ModelRelations\ForumIconRelation;
use Illuminate\Database\Eloquent\Model;

class ForumIcon extends Model
{
    use ForumIconRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='forum_icons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icon'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
