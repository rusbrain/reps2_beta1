<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadReplayRequest extends FormRequest
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
            'file' => 'required|file|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Необходимо указать файл с replay',
            'file.file'     => 'Replay должен быть файлом',
            'file.max'      => 'Максимальный размер файла replay 1mb',
        ];
    }
}
