<?php

namespace App\Http\Requests\Admin\Room;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'location'              => ['required', 'string'],
            'office_room'           => ['required', 'string'],
            'address'               => ['required', 'string'],
            'responsible_person'    => ['required', 'integer'],
            'discription'           => ['nullable', 'string'],
        ];
    }
}
