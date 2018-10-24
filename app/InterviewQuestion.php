<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InterviewQuestion extends Model
{
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
        'is_favorite'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\InterviewVariantsAnswers', 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_answers()
    {
        return $this->hasMany('App\InterviewUserAnswers', 'question_id');
    }

    /**
     * Get random interview question for user
     *
     * @return mixed
     */
    public static function getRandomQuestion()
    {
        $data = InterviewQuestion::where('is_active', 1);

        if(Auth::user()){
            $data->whereDoesntHave('user_answers', function ($query){
                $query->where('user_id', Auth::id());
            });
        } else{
            $data->where('for_login', 0);
        }

        $data = $data->get();
        $favorite = $data->where('is_favorite')->sortBy('created_at')->last();

        if ($favorite){
            return $favorite?$favorite->load('answers'):[];
        }

        $id = rand(0, $data->max('id'));

        $data =  $data->where('id', '=>', $id)->first();

        return $data?$data->load('answers'):[];
    }
}
