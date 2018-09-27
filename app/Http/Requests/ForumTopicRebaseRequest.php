<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumTopicRebaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'section_id'      =>'required|exists:forum_sections,id',
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
            'section_id.required' => 'Не определен раздел форума для публикации',
            'section_id.exists'   => 'Не определен раздел форума для публикации',
        ];
    }
}
