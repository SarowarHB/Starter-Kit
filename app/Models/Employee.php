<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\Enum;
use App\Library\Helper;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Vite;

class Employee extends Model
{
    use HasFactory, HasPermissionsTrait, SoftDeletes;

    protected $fillable = [
        'user_id',
        'mobile',
        'dob',
        'address_line_1',
        'address_line_2',
        'suburb',
        'city',
        'state',
        'post_code',
        'country',
        'profile_image',
        'about_me',
        'emp_type',
        'designation',
        'deleted_at',
    ];


    public $afterCommit = true;

    /*=====================Eloquent Relations======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /*=====================Helper Methods======================*/

    public function getProfileImage(): string
    {
        $path = public_path($this->profile_image);
        if($this->profile_image && is_file($path) && file_exists($path)){
            return asset($this->profile_image);
        }
        return Vite::asset(Enum::NO_AVATAR_PATH);
    }


    public static function getAuthProfileImage()
    {
        $employee = User::getAuthUser()->employee;
        if($employee){
            $path = public_path($employee->profile_image);
            if($employee->profile_image && is_file($path) && file_exists($path)){
                return asset($employee->profile_image);
            }
        }
        return Vite::asset(Enum::NO_AVATAR_PATH);
    }

    public function getFullAddressAttribute(): string
    {
        $address = $this->address_line_1;
        $address .= ', ' . $this->suburb;
        $address .= ', ' . $this->city;
        $address .= ', ' . $this->state;
        $address .= ', ' . $this->post_code;
        $address .= ', ' . Helper::getCountryName($this->country);
        return $address;
    }

}
