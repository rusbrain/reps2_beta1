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
            'user_replay'       => 'nullable|in:1,0',
            'type_id'           => 'required|exists:replay_types,id',
            'title'             => 'required|string|min:3|max:255',
            'content'           => 'required|string|min:3|max:1000',
            'map_id'            => 'nullable|exists:replay_maps,id',
            'replay'            => 'required|file|max:1024',
            'game_version'      => 'required',
            'championship'      => 'nullable|string|max:255',
            'first_country_id'  => 'required|exists:countries,id',
            'second_country_id' => 'required|exists:countries,id',
            'first_race'        => 'required|in:'.$races,
            'second_race'       => 'required|in:'.$races,
            'evaluation'        => 'nullable',
            'length'            => 'nullable',
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
            'user_replay.in'            => 'Не верно указана пренадлежность replay (Пользователя/Gosu)',
            'type_id.required'          => 'Не указан тип replay',
            'type_id.exists'            => 'Не верно указан тип replay',
            'title.required'            => 'Не указан заголовок',
            'title.min'                 => 'Заголовок должен быть не меньше 3 символов',
            'title.max'                 => 'Заголовок должен быть не больше 255 символов',
            'content.required'          => 'Не указан комментарий',
            'content.min'               => 'Комментарий должен быть не меньше 3 символов',
            'content.max'               => 'Комметнарий должен быть не больше 255 символов',
            'map_id.exists'             => 'Не верно указана карта replay',
            'replay.required'           => 'Не указан файл с replay',
            'replay.file'               => 'Replay должн быть файлом',
            'replay.max'                => 'Максимальный размер файла replay 1mb',
            'game_version.required'     => 'Не указана версия игры',
            'championship.max'          => 'Название чемпионала должено быть не больше 255 символов',
            'first_country_id.required' => 'Не выбрана страна первого играка',
            'first_country_id.exists'   => 'Не верно указана страна первого играка',
            'second_country_id.required'=> 'Не выбрана страна второго играка',
            'second_country_id.exists'  => 'Не верно указана страна второго играка',
            'first_race.required'       => 'Не указана расса первого игрока',
            'second_race.required'      => 'Не указана расса второго игрока',
            'first_race.in'             => 'Не верно указана расса первого игрока',
            'second_race.in'            => 'Не верно указана расса второго игрока',
        ];
    }
}
