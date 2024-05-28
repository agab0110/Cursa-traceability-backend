<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'production_id',
        'log_number',
        'lot_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function production(): BelongsTo {
        return $this->belongsTo(Production::class);
    }
}
