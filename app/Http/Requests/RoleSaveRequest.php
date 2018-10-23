<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleSaveRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'title' => 'required|string|min:3|max:255',
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
            'title.required' => 'Не указано название',
            'title.min'      => 'Название должено быть не меньше 3 символов',
            'title.max'      => 'Название должено быть не больше 255 символов',
            'name.required'  => 'Не указано имя',
            'name.min'       => 'Имя должено быть не меньше 3 символов',
            'name.max'       => 'Имя должено быть не больше 255 символов',
        ];
    }
}
