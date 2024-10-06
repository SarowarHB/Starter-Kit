<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'is_for_emp',
        'is_for_member',
        'send_date',
        'message',
    ];
    /*=====================Eloquent======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    /*=====================End======================*/
}
