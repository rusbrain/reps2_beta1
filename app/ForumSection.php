<?php

namespace App;

use App\Traits\ModelRelations\ForumSectionRelation;
use Illuminate\Database\Eloquent\Model;

class ForumSection extends Model
{
    use ForumSectionRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'forum_sections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['position', 'reps_id', 'name', 'title', 'description', 'is_active', 'is_general', 'user_can_add_topics'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return mixed
     */
    public static function active()
    {
        return $general_forum = ForumSection::where('is_active',1)->orderBy('position');
    }

    /**
     * @return mixed
     */
    public static function general_active()
    {
        return $general_forum = ForumSection::where('is_active',1)->where('is_general', 1)->orderBy('position');
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function getSectionByName($name)
    {
       return ForumSection::active()->where('name', $name)->first();
    }
}
