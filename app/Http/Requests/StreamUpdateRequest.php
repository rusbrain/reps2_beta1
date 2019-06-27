<?php

namespace App\Http\Requests;

use App\Stream;
use Illuminate\Foundation\Http\FormRequest;

class StreamUpdateRequest extends FormRequest
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
        $races = implode(",", Stream::$races);

        return [
            'title'                 => 'required|string|min:3|max:255',
            'content'               => 'required|string|min:3|max:1000',
            'stream_url'            => 'required_without:stream|max:1000',
            'country_id'            => 'required|exists:countries,id',
            'race'                  => 'required|in:'.$races,
            'approved'              => 'nullable|in:0,1',
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
            'title.required'                => 'Не указан заголовок',
            'title.min'                     => 'Заголовок должен быть не меньше 3 символов',
            'title.max'                     => 'Заголовок должен быть не больше 255 символов',
            'content.required'              => 'Не указан комментарий',
            'content.min'                   => 'Комментарий должен быть не меньше 3 символов',
            'content.max'                   => 'Комметнарий должен быть не больше 255 символов',
            'stream_url.required_without'   => 'Необходимо указать html код с видео повтором если не указан файл с реплеем',
            'country_id.required'           => 'Не выбрана страна первого играка',
            'country_id.exists'             => 'Не верно указана страна первого играка',          
            'race.required'                 => 'Не указана расса первого игрока',          
            'race.in'                       => 'Не верно указана расса первого игрока'         
        ];
    }
}
