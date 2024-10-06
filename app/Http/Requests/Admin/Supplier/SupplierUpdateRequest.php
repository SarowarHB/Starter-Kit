<?php

namespace App\Http\Requests\Admin\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if($this->country_code && $this->phone)
        {
            $mobile = $this->country_code.'-'.$this->phone ;
            $this->merge(['phone' => $mobile]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'supplier_type'     => ['required', 'string', 'max:255'],
            'phone'             => ['nullable','required_with:phone','string', 'max:18'],
            'email'             => ['nullable', 'email', 'max:255'],
            'address'           => ['nullable', 'string'],
            'contact_person'    => ['nullable', 'string', 'max:255'],
            'company'           => ['nullable', 'string', 'max:255'],
            'logo'              => ['nullable', 'file', 'max:500','mimes:jpeg,jpg,png,gif'],
        ];
    }

    public function messages()
    {
        return [
            'phone.phone_number' => 'Only numbers (0-9) are allowed',
        ];
    }
}
