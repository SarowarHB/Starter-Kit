<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'asset_type',
        'quantity',
        'description',
        'status',
        'price',
        'total',
        'stock',
        'attachments',
        'vender_info',
        'purchased_date',
        'warranty_date',
        'entry_date',
        'created_by',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function getAssetImage()
    {
        $path = public_path($this->attachments);
        if($this->attachments && is_file($path) && file_exists($path)){
            return asset($this->attachments);
        }
        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

}
