<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:32
 */

namespace App\Traits\ModelRelations;


trait ForumSectionRelation
{
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
     * Relations. Sections topics
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forum_topics()
    {
        return $this->hasMany('App\ForumTopic', 'section_id');
    }
    /**
     * Relations. Sections topics
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news_topics()
    {
        return $this->hasMany('App\ForumTopic', 'section_id')->where('news',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function icon()
    {
        return $this->belongsTo('App\SectionIcon');
    }
}