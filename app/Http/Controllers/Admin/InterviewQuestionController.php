<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InterviewQuestionCreateRequest;
use App\Http\Requests\InterviewQuestionRequest;
use App\InterviewQuestion;
use App\Http\Controllers\Controller;
use App\Services\Base\BaseDataService;
use App\Services\Base\InterviewQuestionsService;
use App\Services\Base\AdminViewService;

class InterviewQuestionController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.question.list')->with('question_count', InterviewQuestion::count());
    }

    /**
     * @return array
     */
    public function pagination()
    {
        $questions = InterviewQuestion::withCount('answers', 'user_answers')->paginate(50);
        return BaseDataService::getPaginationData(AdminViewService::getInterview($questions), AdminViewService::getPagination($questions), AdminViewService::getInterviewPopUp($questions));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        return view('admin.question.view')->with('question', InterviewQuestion::getAnswerQuestion($id));
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
        InterviewQuestionsService::update($request, $question_id);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        InterviewQuestionsService::remove($id);
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
        InterviewQuestionsService::create($request);
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
