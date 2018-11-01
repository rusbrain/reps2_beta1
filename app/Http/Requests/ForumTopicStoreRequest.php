<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumTopicStoreRequest extends FormRequest
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
            'section_id'      =>'required|exists:forum_sections,id',
            'title'           =>'required|min:3|max:255',
            'preview_content' =>'nullable|max:1000',
            'content'         =>'required|min:3|max:50000',
            'start_on'        =>'nullable|date',
            'preview_img'     =>'nullable|image',
            'icon'            =>'nullable|string|max:255'
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
            'title.required'      => 'Не указан заголовок',
            'title.min'           => 'Заголовок должен быть не меньше 3 символов',
            'title.max'           => 'Заголовок должен быть не больше 255 символов',
            'preview_content.max' => 'Краткое описание должно быть не больше 1000 символов',
            'content.required'    => 'Основное описание обязаельно для заполнения',
            'content.min'         => 'Основное описание должен быть не меньше 3 символов',
            'start_on.date'       => 'Дата начала должно быть в формате date',
            'preview_img.image'   => 'Файл превью должен быть картинкой',
        ];
    }
}
