<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type',
        'title',
        'short_description',
        'description',
        'start',
        'end',
        'featured_image',
        'is_active',
        'created_by',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function getFeaturedImage()
    {
        $path = public_path($this->featured_image);
        if($this->featured_image && is_file($path) && file_exists($path)){
            return asset($this->featured_image);
        }
        return asset(Enum::NO_AVATAR_PATH);
    }

}
