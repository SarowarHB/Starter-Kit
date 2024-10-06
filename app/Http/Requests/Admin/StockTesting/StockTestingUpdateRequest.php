<?php

namespace App\Http\Requests\Admin\StockTesting;

use Illuminate\Foundation\Http\FormRequest;

class StockTestingUpdateRequest extends FormRequest
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
            'stock_id'          => ['required', 'integer'],
            'testing_date'      => ['required', 'date'],
            'next_testing_date' => ['required', 'date'],
            'status'            => ['required', 'integer'],
            'note'              => ['required', 'string'],
        ];
    }
}
