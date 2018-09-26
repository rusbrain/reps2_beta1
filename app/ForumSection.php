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
}
