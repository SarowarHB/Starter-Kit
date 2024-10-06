<?php

namespace App\Http\Requests\Admin\StockAssign;

use Illuminate\Foundation\Http\FormRequest;

class StockAssignStoreRequest extends FormRequest
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
            'user_id' => ['required', 'integer'],
            'stock_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'assigned_date' => ['required', 'date'],
            'status' => ['required', 'integer'],
            'acknowledgement_status' => ['required'],
            'operator_id' => ['required', 'integer'],
        ];
    }
}
