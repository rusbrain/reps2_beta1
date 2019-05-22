<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminBannerUpdateRequest extends FormRequest
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
            'title'         => 'nullable|string|min:3|max:255',
            'url_redirect'  => 'required|url|max:255',
            'image'         => 'nullable|image|max:2048',
            'is_active'     => 'nullable|boolean',
        ];
    }
}
