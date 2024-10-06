<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'user_id',
        'full_name',
        'subject',
        'message',
        'attachment',
        'department',
        'status',
        'priority',
        'assign_to_id',
        'created_by',
        'assign_id',
    ];

    public $afterCommit = true;

    /*=====================Eloquent Relations======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'assign_to_id');
    }

    public function replies(string $order_by = 'asc')
    {
        return $this->hasMany(TicketReply::class, 'ticket_id', 'id')->orderBy('id', $order_by);
    }

    public function assign(string $order_by = 'asc')
    {
        return $this->hasMany(TicketAssign::class, 'ticket_id', 'id')->orderBy('id', $order_by);
    }

    public function createBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
