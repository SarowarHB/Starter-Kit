<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'payment_method',
        'month_of_salary',
        'salary',
        'bonus',
        'total_salary',
        'trans_date',
        'note',
        'status',
        'created_by',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'employee_id');
    }
    public function createUser()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
