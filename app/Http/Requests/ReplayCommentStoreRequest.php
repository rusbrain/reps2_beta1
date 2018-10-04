<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplayCommentStoreRequest extends BaseStoreCommentRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['replay_id'] = 'required|exists:replays,id';

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

        $messages['replay_id.required'] = 'Не определен коментируемый replay для публикации';
        $messages['replay_id.exists'] = 'Не определен коментируемый replay для публикации';

        return $messages;
    }
}
