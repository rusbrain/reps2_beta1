<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortalSearchRequest extends FormRequest
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
            'text' => 'required|string|min:3|max:255',
            'section' => 'required|in:news,forum,replay'
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
            'text.required' => 'Tекста обязаельно для заполнения',
            'text.min'      => 'Tекста быть не меньше 3 символов',
            'text.max'      => 'Длина текста поиска не должна быть'      
        ];
    }
}
