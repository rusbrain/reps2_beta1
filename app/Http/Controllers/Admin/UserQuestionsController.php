<?php

namespace App\Http\Controllers\Admin;

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

        $table = (string) view('admin.user.questions.list_table')->with(['data' => $questions]);
        $pagination = (string) view('admin.user.pagination')->with(['data' => $questions]);

        return ['table' => $table, 'pagination' => $pagination];
    }
}
