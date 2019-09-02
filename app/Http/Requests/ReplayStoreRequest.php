<?php

namespace App\Http\Requests;

use App\Replay;
use Illuminate\Foundation\Http\FormRequest;

class ReplayStoreRequest extends FormRequest
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
            'user_replay'           => 'required|in:1,0',
            'type_id'               => 'required|exists:replay_types,id',
            'title'                 => 'required|string|min:3|max:255',
            'content'               => 'required|string|min:3|max:1000',
            'map_id'                => 'nullable|exists:replay_maps,id',
            'file_id'               => 'required_without:video_iframe|nullable|exists:files,id',
            'video_iframe'          => 'required_without:file_id|max:1000',
            'first_country_id'      => 'required|exists:countries,id',
            'second_country_id'     => 'required|exists:countries,id',
            'first_race'            => 'required|in:'.$races,
            'second_race'           => 'required|in:'.$races,
            'first_location'        => 'nullable|integer',
            'second_location'       => 'nullable|integer',
            'approved'              => 'nullable|in:0,1',
            'first_name'            => 'nullable',
            'second_name'           => 'nullable',
            'first_apm'             => 'nullable|integer|min:1',
            'second_apm'            => 'nullable|integer|min:1',
            'start_date'            => 'nullable|date_format:Y-m-d'
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
            'user_replay.in'                => 'Не верно указана пренадлежность replay (Пользователя/Gosu)',
            'type_id.required'              => 'Не указан тип replay',
            'type_id.exists'                => 'Не верно указан тип replay',
            'title.required'                => 'Не указан заголовок',
            'title.min'                     => 'Заголовок должен быть не меньше 3 символов',
            'title.max'                     => 'Заголовок должен быть не больше 255 символов',
            'content.required'              => 'Не указан комментарий',
            'content.min'                   => 'Комментарий должен быть не меньше 3 символов',
            'content.max'                   => 'Комметнарий должен быть не больше 255 символов',
            'map_id.exists'                 => 'Не верно указана карта replay',
            'file_id.required_without'      => 'Необходимо указать файл с replay если не указана линка на видео',
            'video_iframe.required_without' => 'Необходимо указать html код с видео повтором если не указан файл с реплеем',
            'game_version_id.required'      => 'Не указана версия игры',
            'game_version_id.exists'        => 'Не верно указана версия игры',
            'championship.max'              => 'Название чемпионала должено быть не больше 255 символов',
            'first_country_id.required'     => 'Не выбрана страна первого играка',
            'first_country_id.exists'       => 'Не верно указана страна первого играка',
            'second_country_id.required'    => 'Не выбрана страна второго играка',
            'second_country_id.exists'      => 'Не верно указана страна второго играка',
            'first_race.required'           => 'Не указана расса первого игрока',
            'second_race.required'          => 'Не указана расса второго игрока',
            'first_race.in'                 => 'Не верно указана расса первого игрока',
            'second_race.in'                => 'Не верно указана расса второго игрока',
            'first_location.integer'        => 'Локация должна быть указана в виде целого числа',
            'second_location.integer'       => 'Локация должна быть указана в виде целого числа',
            'creating_rate.in'              => 'Не верно указана оценка'
        ];
    }
}
