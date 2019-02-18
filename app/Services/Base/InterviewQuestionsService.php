<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 13:25
 */

namespace App\Services\Base;


use App\Http\Requests\InterviewQuestionCreateRequest;
use App\Http\Requests\InterviewQuestionRequest;
use App\InterviewQuestion;
use App\InterviewUserAnswers;
use App\InterviewVariantsAnswers;

class InterviewQuestionsService
{
    /**
     * @param $id
     */
    public static function remove($id)
    {
        InterviewQuestion::where('id', $id)->delete();
        InterviewUserAnswers::where('question_id', $id)->delete();
        InterviewVariantsAnswers::where('question_id', $id)->delete();
    }

    /**
     * @param InterviewQuestionRequest $request
     * @param $question_id
     */
    public static function update(InterviewQuestionRequest $request, $question_id)
    {
        $data = $request->validated();

        $old_ids = array_keys($data['old_answers']);

        $question = InterviewQuestion::find($question_id);

        $question->update(['question' => $data['question']]);
        $question->answers()->whereNotIn('id', $old_ids)->delete();

        foreach ($data['old_answers'] as $key=>$answer){
            InterviewVariantsAnswers::where('id', $key)->update(['answer' => $answer]);
        }

        if($data['new_answers']){
            $answers = [];

            foreach ($data['new_answers'] as $new_answer) {
                if($new_answer){
                    $answers[] =[
                        'answer' => $new_answer,
                        'question_id' => $question_id,
                    ];
                }
            }

            if($answers){
                InterviewVariantsAnswers::insert($answers);

            }
        }
    }

    /**
     * @param InterviewQuestionCreateRequest $request
     */
    public static function create(InterviewQuestionCreateRequest $request)
    {
        $data = $request->validated();

        $question_data = $data;
        unset($question_data['new_answers']);

        $question = InterviewQuestion::create($question_data);

        if($data['new_answers']){
            $answers = [];

            foreach ($data['new_answers'] as $new_answer) {
                if($new_answer){
                    $answers[] =[
                        'answer' => $new_answer,
                        'question_id' => $question->id,
                    ];
                }
            }

            if($answers){
                InterviewVariantsAnswers::insert($answers);

            }
        }
    }
}