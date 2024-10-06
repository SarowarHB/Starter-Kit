<?php

namespace App\Http\Requests\Admin\StockHistory;

use Illuminate\Foundation\Http\FormRequest;

class StockHistoryStoreRequest extends FormRequest
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
            'assign_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'status' => ['required', 'in:'],
            'date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'note' => ['required', 'string'],
            'operator_id' => ['required', 'integer'],
        ];
    }
}
