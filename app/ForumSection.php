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
     * Relations. Sections categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('App\ForumCategory');
    }
}
