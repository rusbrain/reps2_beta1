<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortalSearchRequest extends FormRequest
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
            'search' => 'required|string|min:3|max:255',
            'section' => 'required|in:news,forum,replay'
        ];
    }
}
