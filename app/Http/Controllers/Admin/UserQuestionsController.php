<?php

namespace App\Http\Controllers\Admin;

use App\Services\Base\BaseDataService;
use App\Services\Base\AdminViewService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserQuestionsController extends Controller
{
    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index($id){
        $user = User::find($id);
        return view('admin.user.questions.list')->with(['user' => $user, 'answer_count' => $user->answers_to_questions()->count()]);
    }

    /**
     * @param $id
     * @return array
     */
    public function pagination($id)
    {
        $user = User::find($id);
        $questions = $user->answers_to_questions()->orderBy('created_at', 'desc')->with('question', 'answer')->paginate(50);
        return BaseDataService::getPaginationData(AdminViewService::getQuestions($questions), AdminViewService::getPagination($questions));
    }
}
