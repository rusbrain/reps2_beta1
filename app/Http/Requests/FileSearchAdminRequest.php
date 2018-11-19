<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileSearchAdminRequest extends FormRequest
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
            'size_to'   => 'nullable|boolean',
            'size'      => 'nullable|numeric|min:0|required_with:size_to',
            'text'      => 'nullable|string|max:255',
            'sort'      => 'nullable|in:id,title,type,size,created_at',
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
            'size_to.in'    => 'Не верно указано условие для размера файла',
            'size.numeric'  => 'Размер файла должен быть в виде чиста',
            'size.required_with'  => 'Необходимо указать значение, если указано условие',
            'size.min'      => 'Размер файла не может быть меньше 0',
            'text.max'      => 'Длина текста поиска не должна быть больше 255 символов',
            'used.boolean'  => 'Не верно задан параметр используемости файла',
            'sort.in'       => 'Не верно указан параметр сортировки',
        ];
    }
}
