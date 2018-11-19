<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendUserMessageRequest extends FormRequest
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
            'message' => 'required|max:10000'
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
            'message.required' => 'Введите сообщение',
            'message.max'      => 'Сообщение должено быть не больше 10000 символов',
        ];
    }
}
