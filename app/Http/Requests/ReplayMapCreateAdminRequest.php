<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplayMapCreateAdminRequest extends FormRequest
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
            'file' => 'required|image|max:1024',
            'name' => 'required|string|min:2|max:255'
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
            'file.required' => 'Файл карты не выбран',
            'file.image'    => 'Карта долюна быть изображением (jpeg, png, bmp, gif или svg)',
            'file.max'      => 'Максимальный размер файла 1Мб',
            'name.required' => 'Название карты не указано',
            'name.min'      => 'Минимальная длина имени карты 2 символа',
            'name.max'      => 'Максимальная длина имени карты 255 символов',
        ];
    }
}
