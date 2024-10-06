<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TicketAssign extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'assigned_by',
        'assigned_by_name',
        'assigned_to',
        'assign_to_name',
        'notes',
    ];

    /*=====================Eloquent Relations======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'assigned_by');
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'assigned_to');
    }
}
