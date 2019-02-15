<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:54
 */

namespace App\Traits\ModelRelations;


trait InterviewQuestionRelation
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\InterviewVariantsAnswers', 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_answers()
    {
        return $this->hasMany('App\InterviewUserAnswers', 'question_id');
    }
}