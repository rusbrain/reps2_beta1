<?php

namespace App\Http\Requests;

use App\Stream;
use Illuminate\Foundation\Http\FormRequest;

class StreamSettingRequest extends FormRequest
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
            'headline'                  => 'nullable|in:0,1',
            'main_section'              => 'nullable|in:0,1',
        ];
    }
}
