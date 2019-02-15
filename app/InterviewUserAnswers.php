<?php

namespace App;

use App\Traits\ModelRelations\InterviewUserAnswersRelation;
use Illuminate\Database\Eloquent\Model;

class InterviewUserAnswers extends Model
{
    use InterviewUserAnswersRelation;

    /**
     * Using table name
     *
     * @var string
     */
    protected $table='interview_user_answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'question_id',
        'answer_id',
    ];
}
