<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable =[
        'action_by',
        'log_time',
        'action',
        'subject',
        'record_id',
        'changes',
        'ip',
        'browser'
    ];

    /*=====================Eloquent Relations======================*/
    public function user()
    {
        return $this->belongsTo(User::class, 'action_by');
    }

}
