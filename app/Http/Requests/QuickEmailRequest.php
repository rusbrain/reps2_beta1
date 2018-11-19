<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuickEmailRequest extends FormRequest
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
            'emailto'           =>'required|email|max:255',
            'subject'           =>'required|string|max:100',
            'content'           =>'required|min:3',
        ];
    }
}
