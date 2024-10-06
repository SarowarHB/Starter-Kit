<?php

namespace App\Http\Requests\Admin\Stock;

use Illuminate\Foundation\Http\FormRequest;

class StockStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'product_id'    => ['required', 'integer'],
            'supplier_id'   => ['required', 'integer'],
            'unit_price'    => ['required', 'numeric'],
            'quantity'      => ['required', 'integer'],
            'mac_id'        => ['nullable', 'string', 'max:255'],
            'purchase_date' => ['required', 'date'],
            'warranty_date' => ['nullable', 'date'],
            'testing_date'  => ['nullable', 'date'],
            'location'      => ['required', 'string', 'max:255'],
            'note'          => ['nullable', 'string'],
        ];
    }
}
