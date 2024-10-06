<?php

namespace App\Http\Requests\Admin\Ticket;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignToRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assigned_to'    => ['required', 'integer', 'exists:users,id'],
            'notes'        => ['required', 'string', 'max:555'],
        ];
    }
}
