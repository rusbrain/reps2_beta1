<?php

namespace App\Http\Requests;

use App\Replay;
use Illuminate\Foundation\Http\FormRequest;

class ReplaySearchAdminRequest extends FormRequest
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
            'users'     => 'nullable|in:1,0',
            'approved'  => 'nullable|in:1,0',
            'type'      => 'nullable|exists:replay_types,id',
            'search'    => 'nullable|string|max:255',
            'map'       => 'nullable|exists:replay_maps,id',
            'race'      => 'nullable|in:'.$races,
            'sort'      => 'nullable|in:id,title,user_rating,rating',
            'country'   => 'nullable|exists:countries,id',
            'user_id'   => 'nullable|exists:users,id',
        ];
    }
}
