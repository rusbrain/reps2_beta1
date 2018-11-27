<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterviewQuestionRequest extends FormRequest
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
            'question'      => 'required|string|min:3|max:255',
            'old_answers'   => 'nullable|array',
            'old_answers.*' => 'nullable|string|min:1|max:255',
            'new_answers'   => 'nullable|array',
            'new_answers.*' => 'nullable|string|min:1|max:255',
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
            'question.min'      => 'Вопрос должен быть не меньше 3 символов',
            'question.max'      => 'Вопрос должен быть не больше 255 символов',
            'old_answers.*.min' => 'Вариант ответа должен быть не меньше 1 символа',
            'old_answers.*.max' => 'Вариант ответа должен быть не больше 255 символов',
            'new_answers.*.min' => 'Вариант ответа должен быть не меньше 1 символа',
            'new_answers.*.max' => 'Вариант ответа должен быть не больше 255 символов',
        ];
    }
}
