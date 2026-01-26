<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = ['sale_id', 'finished_product_id', 'quantity', 'price'];

    /**
     * Get the sale that owns the sale item.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Get the finished product associated with the sale item.
     */
    public function finishedProduct(): BelongsTo
    {
        return $this->belongsTo(FinishedProduct::class, 'finished_product_id');
    }
}
