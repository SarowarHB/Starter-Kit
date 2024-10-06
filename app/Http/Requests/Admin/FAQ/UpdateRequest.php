<?php

namespace App\Http\Requests\Admin\FAQ;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'qustion'      => ['required', 'string', 'max:555'],
            'answer'       => ['required', 'string'],
            'position'     => ['nullable', 'integer', 'max:255', 'unique:faqs,position,' . $this->id],
        ];
    }
}
