<?php

namespace App\Http\Requests\Admin\Expense;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'expense_type' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:255'],

            'attachments'  => ['nullable', 'file', 'max:500','mimes:pdf,doc,csv,excel'],
        ];
    }
}
