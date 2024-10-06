<?php

namespace App\Http\Requests\Admin\Ticket;

use App\Models\Ticket;
use App\Models\User;
use App\Library\Enum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'created_by' => User::getAuthUser()->id,
        ]);
    }

    public function rules()
    {
        return [
            'subject'       => ['required', 'string', 'max:255'],
            'user_id'       => ['required', 'integer', 'exists:users,id'],
            'full_name'     => ['nullable', 'string', 'max:25'],
            'department'    => ['required', 'string', 'max:25'],
            'priority'      => ['required', 'integer', 'max:25'],
            'message'       => ['required', 'string', 'max:5555'],
            'attachment'    => ['nullable','file', 'max:3000'],
            'created_by'    => ['required', 'integer', 'max:25'],

        ];
    }
}
