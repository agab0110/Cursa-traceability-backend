<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pre_production_id',
        'log_number',
        'lot_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function preProduction(): BelongsTo {
        return $this->belongsTo(PreProduction::class);
    }

    public function transports(): HasMany {
        return $this->hasMany(Transport::class);
    }

    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }
}
