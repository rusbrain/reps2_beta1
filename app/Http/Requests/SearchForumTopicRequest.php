<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchForumTopicRequest extends FormRequest
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
            'section_id' => 'nullable|exists:forum_sections,id',
            'text'       => 'nullable|string|max:255',
            'user_id'    => 'nullable|exists:users,id',
            'min_rating' => 'nullable|numeric|min:0',
            'min_date'   => 'nullable|date_format:Y-m-d',
            'max_date'   => 'nullable|date_format:Y-m-d',
            'news'       => 'nullable',
            'approved'   => 'nullable',
            'sort'       => 'nullable'
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
            'section_id.exists'             => 'Не верно указан раздел форума',
            'text.max'                      => 'Строка запроса должна бфть не более 255 символов',
            'user_id.exists'                => 'Указанный пользователь не обнаружен',
            'min_rating.numeric'            => 'Минимальный рейтинг должен быть числом',
            'min_rating.min'                => 'Минимальный рейтинг должен быть не меньше 0',
            'min_date.date_format'          => 'Не верный формат даты',
            'max_date.date_format'          => 'Не верный формат даты',
        ];
    }
}
