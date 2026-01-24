<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Part extends Model
{
    protected $fillable = ['name', 'sku', 'unit', 'stock', 'min_stock'];

    /**
     * Get the stock movements for the part.
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(PartStock::class);
    }
}
