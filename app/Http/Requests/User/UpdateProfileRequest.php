<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name'          => 'required|max:255',
            'country'       => 'exists:countries,id',
            'homepage'      => 'nullable|url|max:255',
            'vk_link'       => 'nullable|url|max:255',
            'fb_link'       => 'nullable|url|max:255',
            'isq'           => 'nullable|string|max:255',
            'skype'         => 'nullable|string|max:255',
            'signature'     => 'nullable|string|max:255',
            'mouse'         => 'nullable|string|max:255',
            'keyboard'      => 'nullable|string|max:255',
            'headphone'     => 'nullable|string|max:255',
            'mousepad'      => 'nullable|string|max:255',
            'birthday'      => 'nullable|string|max:255',
            'avatar'        => 'nullable|image|max:2048',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'  => 'Не указно имя.',
            'name.max'       => 'Максимальная длина имени 255 символов.',
            'country.exists' => 'Не верно указана страна.',
            'homepage.url'   => 'Домашняя страница должна быть ссылкой.',
            'vk_link.url'    => 'Страница Вконтакте должна быть ссылкой.',
            'fb_link.url'    => 'Страница Facebook должна быть ссылкой.',
            'homepage.max'   => 'Максимальная длина ссылки домашней страниы 255 символов.',
            'vk_link.max'    => 'Максимальная длина ссылки на сраницу вконтакте 255 символов.',
            'fb_link.max'    => 'Максимальная длина ссылки на страницу Facebook 255 символов.',
            'isq.max'        => 'Максимальная длина номера ISQ 255 символов.',
            'skype.max'      => 'Максимальная длина Skype 255 символов.',
            'signature.max'  => 'Максимальная длина подписи 255 символов.',
            'mouse.max'      => 'Максимальная длина названия мыши 255 символов.',
            'keyboard.max'   => 'Максимальная длина названия клавиатуры 255 символов.',
            'headphone.max'  => 'Максимальная длина названия наушников 255 символов.',
            'mousepad.max'   => 'Максимальная длина названия коврика для мыши 255 символов.',
            'avatar.max'     => 'Максимальный размер картинки аватара 2мб.',
        ];
    }
}
