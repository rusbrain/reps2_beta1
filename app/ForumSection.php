<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumSection extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'forum_sections';

    /**
     * Relations. Sections topics
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics()
    {
        return $this->hasMany('App\ForumTopic', 'section_id');
    }

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
}
