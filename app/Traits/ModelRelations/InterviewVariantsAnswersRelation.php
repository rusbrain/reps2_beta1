<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:55
 */

namespace App\Traits\ModelRelations;


trait InterviewVariantsAnswersRelation
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\InterviewQuestion', 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_answers()
    {
        return $this->hasMany('App\InterviewUserAnswers', 'answer_id');
    }
}