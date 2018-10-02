<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetReplayUserRatingRequest extends FormRequest
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
            'rating'  => 'required|in:1,2,3,4,5',
            'comment' => 'nullable|max:255'
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
            'rating.required' => 'Не указана оценка',
            'rating.in'       => 'Указано не верное значение',
            'comment.max'     => 'Коментарий должен быть не больше 255 символов',
        ];
    }
}
