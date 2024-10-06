<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'name',
        'quantity',
        'price',
        'total',
        'lose_or_profit',
        'sale_to',
        'sale_date',
        'note',
        'created_by',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
