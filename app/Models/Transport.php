<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate',
        'driver',
        'company',
        'lot_id',
        'sawmill_id',
        'shipping',
        'shipping_date',
        'shipped',
        'shipped_date'
    ];

    protected $casts = [
        'shipping_date' => 'datetime',
        'shipped_date' => 'datetime'
    ];

    public function lots(): HasMany {
        return $this->hasMany(Lot::class);
    }

    public function sawmill(): BelongsTo {
        return $this->belongsTo(Sawmill::class);
    }
}
