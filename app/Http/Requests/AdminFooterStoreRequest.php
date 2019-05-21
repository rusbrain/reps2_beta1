<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminFooterStoreRequest extends FormRequest
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
            'title'     => 'required|string|min:3|max:255',
            'position'  => 'nullable|in:1,2,3,4,5',
            'text'      => 'required|string|max:255',
            'email'     => 'nullable|email',
            'icq'       => 'nullable|string|max:255',
            'approved'  => 'nullable|boolean',
        ];
    }
}
