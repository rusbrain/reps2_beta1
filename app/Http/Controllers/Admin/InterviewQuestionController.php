<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InterviewQuestionCreateRequest;
use App\Http\Requests\InterviewQuestionRequest;
use App\InterviewQuestion;
use App\InterviewUserAnswers;
use App\InterviewVariantsAnswers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InterviewQuestionController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.question.list')->with('data', InterviewQuestion::withCount('answers', 'user_answers')->paginate(50));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        return view('admin.question.view')->with('question', InterviewQuestion::where('id',$id)->with(['answers' => function($q){
            $q->withCount('user_answers');
        }])->first());
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.question.edit')->with('question', InterviewQuestion::where('id',$id)->with('answers')->first());
    }

    /**
     * @param InterviewQuestionRequest $request
     * @param $question_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(InterviewQuestionRequest $request, $question_id)
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

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        InterviewQuestion::where('id', $id)->delete();
        InterviewUserAnswers::where('question_id', $id)->delete();
        InterviewVariantsAnswers::where('question_id', $id)->delete();

        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.question.add');
    }

    /**
     * @param InterviewQuestionCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(InterviewQuestionCreateRequest $request)
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

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function active($id)
    {
        InterviewQuestion::where('id', $id)->update(['is_active' => 1]);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notActive($id)
    {
        InterviewQuestion::where('id', $id)->update(['is_active' => 0]);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forLogin($id)
    {
        InterviewQuestion::where('id', $id)->update(['for_login' => 1]);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notForLogin($id)
    {
        InterviewQuestion::where('id', $id)->update(['for_login' => 0]);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function favorite($id)
    {
        InterviewQuestion::where('id', $id)->update(['is_favorite' => 1]);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notFavorite($id)
    {
        InterviewQuestion::where('id', $id)->update(['is_favorite' => 0]);
        return back();
    }
}
