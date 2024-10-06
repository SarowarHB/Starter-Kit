<?php

namespace App\Http\Requests\Admin\Asset;

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
            'name' => ['required', 'string', 'max:255'],
            'asset_type' => ['required', 'string', 'max:255'],
            'purchased_date' => ['required', 'string', 'max:255'],
            'warranty_date' => ['nullable', 'string', 'max:255'],
            'vender_info' => ['required', 'string', 'max:255'],

            'quantity' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'description' => ['required', 'string', 'max:255'],

            'attachments'  => ['nullable', 'file', 'max:500','mimes:jpeg,jpg,png,gif'],
        ];
    }
}
