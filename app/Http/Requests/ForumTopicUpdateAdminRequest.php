<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumTopicUpdateAdminRequest extends ForumTopicUpdateRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge($rules, [
            'preview_img'  => 'nullable|image',
            'news'         => 'nullable|boolean',
            'approved'     => 'nullable|boolean',
        ]);
    }
}