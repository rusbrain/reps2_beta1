<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'forum_categories';

    /**
     * Relations. Sections category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo('App\ForumSection');
    }
}
