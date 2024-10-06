<?php

namespace App\Http\Requests\Admin\Employee\EmergencyContact;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if($this->country_code && $this->mobile_number)
        {
            $mobile = $this->country_code.'-'.$this->mobile_number ;
            $this->merge(['mobile_number' => $mobile]);
        }
    }

    public function rules()
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'address'       => ['nullable', 'string', 'max:555'],
            'email'         => ['nullable', 'string', 'max:255'],
            'mobile_number' => ['required', 'phone_number', 'string', 'max:18'],
            'relationship'  => ['required', 'string', 'max:255'],
            'note'          => ['nullable', 'string', 'max:255'],
        
            'image'         => ['nullable', 'file', 'max:500','mimes:jpeg,jpg,png,gif'],
        ];
    }

    public function messages()
    {
        return [
            'mobile_number.phone_number' => 'Only numbers (0-9) are allowed',
        ];
    }
}
