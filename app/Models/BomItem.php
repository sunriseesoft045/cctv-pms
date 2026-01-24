<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BomItem extends Model
{
    protected $fillable = ['bom_id', 'part_id', 'qty_required'];

    public function bom(): BelongsTo
    {
        return $this->belongsTo(Bom::class);
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class, 'part_id');
    }
}
