<?php

namespace App\Http\Requests\Admin\CategoryType;

use Illuminate\Foundation\Http\FormRequest;

class CategoryTypeUpdateRequest extends FormRequest
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
            'name'       => ['required', 'string', 'max:255'],
            'unique_key' => ['required', 'string', 'max:255', 'unique:category_types,unique_key,' . $this->id],
            'entry_type' => ['required']
        ];
    }
}
