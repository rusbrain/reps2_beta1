<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PictureUpdateRequest extends FormRequest
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
            // 'image'         =>'required|image|max:2048',
            'category_id'   =>'required',
            'comment'       =>'nullable|string|max:1000',
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
            // 'image.required'        => 'Не выбран файл картинки.',
            'category_id.required'  => 'Пожалуйста, введите категория',
            'image.image'           => 'Файл должен быть картинкой.',
            'image.max'             => 'Максимальный размер загрузаемого файла 2 мб',
            'comment.string'        => 'Комментарий должен быть строкой',
            'comment.max'           => 'Комментарий должен быть не больше 1000 символов',  
        ];
    }
}
