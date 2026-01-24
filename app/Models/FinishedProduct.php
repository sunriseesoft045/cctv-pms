<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinishedProduct extends Model
{
    protected $fillable = ['name', 'sku', 'stock'];

    public function assemblies(): HasMany
    {
        return $this->hasMany(Assembly::class);
    }
}
