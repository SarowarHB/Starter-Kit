<?php

namespace App\Http\Requests\Admin\Config;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if($this->country_code && $this->phone)
        {
            $phone = $this->country_code.'-'.$this->phone ;
            $this->merge(['phone' => $phone]);
        }
    }

    public function rules()
    {
        return [
            'app_title'         => ['required', 'string', 'max:255'],
            'country_code'      => ['nullable', 'string', 'max:255'],
            'phone'             => ['nullable', 'phone_number', 'string', 'max:255'],
            'state'             => ['nullable', 'string', 'max:255'],
            'city'              => ['nullable', 'string', 'max:255'],
            'zip_code'          => ['nullable', 'string', 'max:10'],
            'country'           => ['nullable', 'string', 'max:30'],
            'address'           => ['nullable', 'string', 'max:255'],
            'version'           => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'max:255'],
            'copyright'         => ['required', 'string', 'max:255'],
            'copyright_url'         => ['required', 'string', 'max:255'],
            'currency_name'     => ['nullable', 'string', 'max:25'],
            'currency_symbol'   => ['nullable', 'string', 'max:25'],
            'logo'              => ['nullable', 'file', 'max:500','mimes:jpeg,jpg,png,gif'],
            'favicon'           => ['nullable', 'file', 'max:500','mimes:jpeg,jpg,png,gif'],
            'og_image'          => ['nullable', 'file', 'max:500','mimes:jpeg,jpg,png,gif'],
        ];
    }

    public function messages()
    {
        return [
            'phone.phone_number' => 'Only numbers (0-9) are allowed',
        ];
    }
}
