<?php

namespace App\Http\Requests\Admin\AssetSale;

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
            'id' => ['required', 'integer', 'exists:asset_sales,id'],
            'asset_id' => ['required', 'integer', 'exists:assets,id'],
            'name' => ['required', 'string', 'max:255'],

            'quantity' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],

            'sale_to' => ['required', 'string', 'max:255'],
            'sale_date' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }
}
