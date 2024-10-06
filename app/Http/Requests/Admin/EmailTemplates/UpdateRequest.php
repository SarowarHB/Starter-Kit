<?php

namespace App\Http\Requests\Admin\EmailTemplates;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'subject' => ['required', 'string', 'max:5555'],
            'message' => ['required', 'string', 'max:5555', 'min:15'],
        ];
    }
}
