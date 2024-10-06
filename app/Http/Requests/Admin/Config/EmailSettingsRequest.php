<?php

namespace App\Http\Requests\Admin\Config;

use Illuminate\Foundation\Http\FormRequest;

class EmailSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mail_driver'    => ['required', 'string', 'max:255'],
            'mail_host'      => ['required', 'string', 'max:255'],
            'mail_port'      => ['required', 'string', 'max:255'],
            'mail_user_name' => ['required', 'string', 'max:255'],
            'mail_password'  => ['required', 'string', 'max:255'],
            'mail_from'      => ['required', 'string', 'max:255'],
            'mail_from_name' => ['required', 'string', 'max:255'],
            'encryption'     => ['required', 'string', 'max:255'],
        ];
    }
}
