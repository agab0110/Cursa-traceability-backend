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
        'sawmill_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function sawmill(): BelongsTo {
        return $this->belongsTo(Sawmill::class);
    }
}
