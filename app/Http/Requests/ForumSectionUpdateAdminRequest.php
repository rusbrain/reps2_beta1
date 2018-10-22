<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumSectionUpdateAdminRequest extends FormRequest
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
            'position'              => 'required|min:0',
            'name'                  => 'required|string|max:255',
            'title'                 => 'required|string|max:255',
            'description'           => 'required|string|max:255',
            'is_active'             => 'nullable|boolean',
            'is_general'            => 'nullable|boolean',
            'user_can_add_topics'   => 'nullable|boolean',
        ];
    }
}
