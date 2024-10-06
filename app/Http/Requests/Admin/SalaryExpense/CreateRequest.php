<?php

namespace App\Http\Requests\Admin\SalaryExpense;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $month = $this->month_of_salary.'-'.'01' ;
        $this->merge(['month_of_salary' => $month]);
    }

    public function rules()
    {
        return [
            'employee_id'       => ['required', 'integer', 'exists:users,id'],
            'payment_method'    => ['required', 'string'],
            'month_of_salary'   => ['required', 'string', 'max:255'],
            'salary'            => ['required', 'max:255'],
            'bonus'             => ['required', 'max:255'],
            'total_salary'      => ['required', 'max:255'],
            'trans_date'        => ['required', 'string', 'max:255'],
            'note'              => ['nullable', 'string', 'max:255'],
        ];
    }
}
