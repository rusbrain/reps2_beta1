<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterviewVariantsAnswers extends Model
{
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='interview_variants_answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer',
        'question_id',
    ];

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
