<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterviewQuestionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question'      => 'required|string|min:1|max:255',
            'is_active'     => 'nullable|boolean',
            'is_favorite'   => 'nullable|boolean',
            'for_login'     => 'nullable|boolean',
            'new_answers'   => 'required|array',
            'new_answers.*' => 'required|string|min:1|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'question.required' => 'Не указан вопрос',
            'question.min'      => 'Вопрос должен быть не меньше 1 символов',
            'question.max'      => 'Вопрос должен быть не больше 255 символов',
            'new_answers.required' => 'Не указаны варианты ответов',
            'new_answers.*.min' => 'Вариант ответа должен быть не меньше 1 символов',
            'new_answers.*.max' => 'Вариант ответа должен быть не больше 255 символов',
        ];
    }
}
