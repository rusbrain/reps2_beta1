<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'email'     => 'required|email|exists:users,email',
            'password'  => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'    => 'Email обязательный для заполнения',
            'email.email'       => 'Введен не верный формат Email',
            'email.exist'       => 'Такой Email не найден. Проверьте правильность ввода ли зарегестрируйтесь',
            'password.required' => 'Пароль обязательный для заполнения',
        ];
    }
}
