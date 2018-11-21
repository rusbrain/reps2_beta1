<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReplaySearchRequest extends FormRequest
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
            'text'                  => 'nullable|string|max:255',
            'first_country_id'      => 'nullable|exists:countries,id',
            'second_country_id'     => 'nullable|exists:countries,id',
            'first_race'            => ['nullable',
                                        Rule::in(['All','Z','T','P'])],
            'second_race'           => ['nullable',
                                        Rule::in(['All','Z','T','P'])],
            'map_id'                => 'nullable|exists:replay_maps,id',
            'type_id'               => 'nullable|exists:replay_types,id',
            'sort_by'               => 'nullable|in_array:[game_version,rating,user_rating,evaluation,length,title,created_at]',
            'sort_type'             => 'nullable|in_array:[asc,desc]',
            'user_replay'           => 'nullable|in_array:[0,1]',
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
            'text.max'                  => 'Максимальная длина фразы для поиска 255 символов',
            'first_country_id.exists'   => 'Не верно указана страна',
            'second_country_id.exists'  => 'Не верно указана страна',
            'first_race.in'             => 'Не верно указана раса',
            'second_race.in'            => 'Не верно указана раса',
            'map_id.exists'             => 'Не верно указана карта',
            'sort_by.in_array'          => 'Не верно указан параметр сортиовки',
            'sort_type.in_array'        => 'Не верно указан тип сортиовки',
            'user_replay.in_array'      => 'Не верно указан вид replay',
            'type_id.exists'            => 'Не верно указан тип replay',
        ];
    }
}
