<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bill_to',
        'ship_to',
        'date',
        'due_date',
        'payment_terms',
        'po_number',
        'subtotal',
        'tax',
        'discount',
        'shipping',
        'total',
        'paid',
        'balance',
        'notes',
        'terms',
    ];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}