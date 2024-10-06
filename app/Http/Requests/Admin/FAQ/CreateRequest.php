<?php

namespace App\Http\Requests\Admin\FAQ;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // dd($this->all());
        return [
            'qustion'      => ['required', 'string', 'max:555'],
            'answer'       => ['required', 'string'],
            'position'     => ['nullable', 'integer', 'max:255','unique:faqs,position'],
        ];
    }
}
