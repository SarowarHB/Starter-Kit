<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_type',
        'title',
        'tags',
        'short_description',
        'description',
        'featured_image',
        'status',
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

    public static function getBlogById(int $id)
    {
        return self::where('created_by',$id)->orderBy('id','desc')->get();
    }
}
