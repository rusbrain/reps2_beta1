<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicCommentStoreRequest extends BaseStoreCommentRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['topic_id'] = 'required|exists:forum_topics,id';

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

        $messages['topic_id.required'] = 'Не определен коментируемый пост для публикации';
        $messages['topic_id.exists'] = 'Не определен коментируемый пост для публикации';

        return $messages;
    }
}
