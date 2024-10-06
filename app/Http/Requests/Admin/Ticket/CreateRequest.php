<?php

namespace App\Http\Requests\Admin\Ticket;

use App\Models\Ticket;
use App\Models\User;
use App\Library\Enum;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $ticket_id = Ticket::orderBy('id', 'desc')->pluck('id')->first();
        if($ticket_id >= 1){
            $this->merge([
                'ticket_id' => Enum::PROJECT_ID_TAG.'-'.(5000+$ticket_id),
            ]);
         }else{
            $this->merge([
                'ticket_id' => Enum::PROJECT_ID_TAG.'-5000',
            ]);
         }

        $this->merge([
            'created_by' => User::getAuthUser()->id,
        ]);
    }

    public function rules()
    {
        return [
            'ticket_id'     => ['required', 'string', 'max:255'],
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
