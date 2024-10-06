<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockAssign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'stock_id',
        'quantity',
        'assigned_date',
        'status',
        'acknowledgement_status',
        'operator_id',
        'received_at',
        'received_by',
        'note'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function receivedBy()
    {
        return $this->hasOne(User::class, 'id', 'received_by');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
