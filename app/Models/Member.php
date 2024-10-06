<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Vite;
use App\Library\Enum;
use App\Library\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory, SoftDeletes;

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
        'photo_id',
        'photo_id_verified_at',
        'deleted_at',
    ];

    public $afterCommit = true;

    /*=====================Eloquent Relations======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /*=====================Helper Methods======================*/

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

    public function getProfileImage(): string
    {
        $path = public_path($this->profile_image);
        if($this->profile_image && is_file($path) && file_exists($path)){
            return asset($this->profile_image);
        }
        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public function getNIDImage(): string
    {
        $path = public_path($this->photo_id);
        if($this->photo_id && is_file($path) && file_exists($path)){
            return asset($this->photo_id);
        }
        return Vite::asset(Enum::NO_IMAGE_PATH);
    }
}
