<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumTopicUpdateAdminRequest extends ForumTopicUpdteRequest
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
            'section_id'        => 'required|exists:forum_sections,id',
            'preview_img'       =>'nullable|image',
            'news'              =>'nullable|boolean',
            'approved'          =>'nullable|boolean',
        ]);
    }
}