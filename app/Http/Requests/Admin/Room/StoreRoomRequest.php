<?php

namespace App\Http\Requests\Admin\Room;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
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
