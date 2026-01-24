<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    protected $fillable = [
        'vendor_id',
        'invoice_no',
        'total_amount',
        'status',
        'created_by',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'purchase_id');
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
