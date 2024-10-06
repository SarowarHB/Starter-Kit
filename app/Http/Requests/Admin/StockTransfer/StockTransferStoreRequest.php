<?php

namespace App\Http\Requests\Admin\StockTransfer;

use Illuminate\Foundation\Http\FormRequest;

class StockTransferStoreRequest extends FormRequest
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
            'stock_id' => ['required', 'integer'],
            'previous_location' => ['required', 'string', 'max:255'],
            'current_location' => ['required', 'string', 'max:255'],
            'previous_quantity' => ['required', 'integer'],
            'current_quantity' => ['required', 'integer'],
            'note' => ['required', 'string'],
        ];
    }
}
