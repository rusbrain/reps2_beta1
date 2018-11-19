<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveNewPasswordRequest extends FormRequest
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
            'password'                  => 'required|confirmed|min:8|max:255',
            'password_update_token'     => 'required|exists:user_email_tokens,token'
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
            'password.required'                 => 'Не указан новый пароль',
            'password.confirmed'                => 'Пароль не подтвержден или подтвержден не верно',
            'password.min'                      => 'Минимальная длина пароля 8 символов',
            'password.max'                      => 'Максимальная длина пароля 255 символов',
            'password_update_token.required'    => 'Не верно указан Token',
            'password_update_token.exists'      => 'Указанный Token не существует',
        ];
    }
}
