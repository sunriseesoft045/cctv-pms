<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_no',
        'total_amount',
        'gst_amount',
        'status',
        'created_by',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'sale_id');
    }

    // Accessor for total amount paid
    public function getAmountPaidAttribute(): float
    {
        return $this->payments()->sum('amount');
    }

    // Accessor for outstanding due amount
    public function getAmountDueAttribute(): float
    {
        return $this->total_amount - $this->getAmountPaidAttribute();
    }
}
