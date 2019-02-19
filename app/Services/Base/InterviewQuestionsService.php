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
use Illuminate\Support\Facades\Auth;

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

    /**
     * Get random interview question for user
     *
     * @return mixed
     */
    public static function getRandomQuestion()
    {
        $data = InterviewQuestion::where('is_active', 1)->has('answers');

        if(Auth::user()){
            $data->whereDoesntHave('user_answers', function ($query){
                $query->where('user_id', Auth::id());
            });
        } else{
            $data->where('for_login', 0);
        }

        $data = $data->get();

        $favorite = clone $data;
        $favorite = $favorite->where('is_favorite')->sortBy('created_at')->last();
        if ($favorite){
            return $favorite?$favorite->load('answers'):[];
        }

        $ids = [];
        foreach ($data as $datum){
            $ids[] = $datum->id;
        }

        if($ids){
            $id = array_rand($ids);
            $data =  $data->where('id', $ids[$id])->first();
            return $data?$data->load('answers'):[];
        }

        return [];
    }
}