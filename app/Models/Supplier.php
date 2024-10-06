<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Vite;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'supplier_type',
        'phone',
        'email',
        'address',
        'contact_person',
        'company',
        'logo',
        'operator_id',
        'is_active',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function supplierType()
    {
        return $this->hasOne(CategoryType::class,'id','supplier_type');
    }

    /*=====================Helper Methods======================*/

    public function getProfileImage(): string
    {
        $path = public_path($this->logo);
        if($this->logo && is_file($path) && file_exists($path)){
            return asset($this->logo);
        }
        return Vite::asset(Enum::NO_IMAGE_PATH);
    }
}
