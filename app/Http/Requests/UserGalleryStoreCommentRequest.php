<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGalleryStoreCommentRequest extends BaseStoreCommentRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['gallery_id'] = 'required|exists:user_galleries,id';

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $messages = parent::messages();

        $messages['gallery_id.required'] = 'Не определена коментируемая фотография';
        $messages['gallery_id.exists'] = 'Не определена коментируемая фотография';

        return $messages;
    }
}
