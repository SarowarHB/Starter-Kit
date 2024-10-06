<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'user_name',
        'is_admin_reply',
        'comment',
        'attachment',
        'ticket_assign_id',
        'solution_time',
    ];

   /*=====================Eloquent Relations======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class, 'id', 'ticket_id');
    }
}
