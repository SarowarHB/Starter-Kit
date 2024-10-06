<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Library\Enum;
use PHPUnit\Framework\Constraint\Operator;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait, SoftDeletes;

    protected $fillable = [
        'f_name',
        'm_name',
        'l_name',
        'nick_name',
        'email',
        'password',
        'user_type',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $appends = [
        'full_name'
    ];

    public $afterCommit = true;

    /*=====================Eloquent Relations======================*/
    public function employee()
    {
        return $this->hasOne(Employee::class,'user_id','id');
    }

    public function member(bool $with_trashed = false)
    {
        if($with_trashed)
            return $this->hasOne(Member::class,'user_id','id')->withTrashed()->first();

        return $this->hasOne(Member::class,'user_id','id');
    }

    public function emergency()
    {
        return $this->hasOne(EmergencyContact::class, 'user_id', 'id');
    }

    public function assigns()
    {
        return $this->hasMany(StockAssign::class,'user_id','id');
    }

    /*=====================Helper Methods======================*/
    public function getFullNameAttribute()
    {
        $name = $this->f_name;
        if($this->m_name)
            $name .=  ' ' . $this->m_name;
        $name .= ' ' . $this->l_name;
        return $name;
    }

    public static function getAuthUser()
    {
        return auth()->user();
    }

    public static function getAll()
    {
        return self::all();
    }

    public function role()
    {
        return $this->roles()->first();
    }

    public function getRole()
    {
        return $this->roles()->get();
    }

    public function isEmployee()
    {
        return $this->user_type == Enum::USER_TYPE_ADMIN;
    }

    public function isMember()
    {
        return $this->user_type == Enum::USER_TYPE_MEMBER;
    }

    public function isRoom()
    {
        return $this->user_type == Enum::USER_TYPE_ROOM;
    }

    public static function getAuthUserRole()
    {
        return auth()->user()->roles()->first();
    }

    public static function getUserTypeWise(string $type = null)
    {
        return self::where('user_type', $type)->get();
    }

}
