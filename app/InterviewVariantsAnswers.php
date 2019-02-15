<?php

namespace App;

use App\Traits\ModelRelations\InterviewVariantsAnswersRelation;
use Illuminate\Database\Eloquent\Model;

class InterviewVariantsAnswers extends Model
{
    use InterviewVariantsAnswersRelation;

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
}
