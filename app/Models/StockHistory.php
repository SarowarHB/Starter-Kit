<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stock_id',
        'assign_id',
        'quantity',
        'status',
        'date',
        'location',
        'note',
        'operator_id',
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function assign(): BelongsTo
    {
        return $this->belongsTo(StockAssign::class, 'assign_id');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
