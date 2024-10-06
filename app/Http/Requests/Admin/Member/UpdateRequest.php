<?php

namespace App\Http\Requests\Admin\Member;

use App\Library\Enum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if($this->country_code && $this->mobile)
        {
            $mobile = $this->country_code.'-'.$this->mobile ;
            $this->merge(['mobile' => $mobile]);
        }
    }

    public function rules()
    {
        return [
            'user.f_name'       => ['required', 'string', 'max:255'],
            'user.m_name'       => ['nullable', 'string', 'max:255'],
            'user.l_name'       => ['required', 'string', 'max:255'],
            'user.nick_name'    => ['required', 'string', 'max:255'],
            'user.email'        => ['required', 'string', 'max:255'],

            'mobile'            => ['required', 'phone_number', 'string', 'max:15'],
            'dob'               => ['required', 'string', 'max:255'],
            'address_line_1'    => ['required', 'string', 'max:255'],
            'address_line_2'    => ['nullable', 'string', 'max:255'],
            'suburb'            => ['nullable', 'string', 'max:255'],
            'city'              => ['required', 'string', 'max:255'],
            'state'             => ['nullable','string', 'max:255'],
            'country'           => ['required', 'string', 'max:255'],
            'post_code'         => ['required', 'string', 'max:10'],
            'about_me'          => ['nullable', 'string', 'max:255'],

            'photo_id'          => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],
            'profile_image'     => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],
        ];

    }

    public function messages()
    {
        return [
            'mobile.phone_number' => 'Only numbers (0-9) are allowed',
        ];
    }
}
