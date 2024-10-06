<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location',
        'address',
        'nick_name',
        'responsible_person',
        'discription',
        'operator_id',
    ];

    /*=====================Eloquent Relations======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function operator()
    {
        return $this->hasOne(User::class, 'id', 'operator_id');
    }

    public function responsible()
    {
        return $this->hasOne(User::class, 'id', 'responsible_person');
    }

    /*=====================Helper Methods======================*/
}
