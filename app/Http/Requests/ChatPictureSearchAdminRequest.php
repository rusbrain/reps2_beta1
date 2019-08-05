<?php

namespace App\Http\Requests;

use App\ChatPicture;
use Illuminate\Foundation\Http\FormRequest;

class ChatPictureSearchAdminRequest extends FormRequest
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
            'charactor'     => 'nullable|string',
            'category_id'   => 'nullable'
        ];
    }
}
