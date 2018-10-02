<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplayCommentStoreRequest extends FormRequest
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
            'replay_id' =>'required|exists:replays,id',
            'title'=>'nullable|min:3|max:255',
            'content'=>'required|max:1000',
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
            'replay_id.required'   => 'Не определен коментируемый replay для публикации',
            'replay_id.exists'     => 'Не определен коментируемый replay для публикации',
            'title.min'           => 'Заголовок должен быть не меньше 3 символов',
            'title.max'           => 'Заголовок должен быть не больше 255 символов',
            'content.required'    => 'Основное описание обязаельно для заполнения',
            'content.min'         => 'Основное описание должен быть не больше 1000 символов',
        ];
    }
}
