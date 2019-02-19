<?php

namespace App;

use App\Traits\ModelRelations\InterviewQuestionRelation;
use Illuminate\Database\Eloquent\Model;

class InterviewQuestion extends Model
{
    use InterviewQuestionRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='interview_questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'is_active',
        'is_favorite',
        'for_login'
    ];

    /**
     * @param $id
     * @return mixed
     */
    public static function getAnswerQuestion($id)
    {
        return InterviewQuestion::where('id',$id)->with(['answers' => function($query){
            $query->withCount('user_answers');
        }])->first();
    }
}
