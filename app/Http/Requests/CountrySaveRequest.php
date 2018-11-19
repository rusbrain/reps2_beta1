<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountrySaveRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'code' => 'required|string|min:2|max:4',
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
            'name.required' => 'Не указано название',
            'name.min'      => 'Название должено быть не меньше 2 символов',
            'name.max'      => 'Название должено быть не больше 255 символов',
            'code.required'  => 'Не указано имя',
            'code.min'       => 'Имя должено быть не меньше 2 символов',
            'code.max'       => 'Имя должено быть не больше 4 символов',
        ];
    }
}
