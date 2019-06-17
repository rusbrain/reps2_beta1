<?php

namespace App\Http\Requests\User;

use App\Replay;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequestChange extends FormRequest
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
        $races = implode(",", Replay::$races);
        return [
            'old_password'          => 'required|string',
            'password'              => 'required|string|min:8|max:255|confirmed',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'old_password.required' => 'Не указан новый пароль.',           
            'password.required'     => 'Не указан новый пароль.',
            'password.confirmed'    => 'Пароль не подтвержден или подтвержден не верно.',
            'password.min'          => 'Минимальная длина пароля 8 символов.',
            'password.max'          => 'Максимальная длина пароля 255 символов.',
          
        ];
    }
}
