<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Production extends Model
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

    public function preProduction(): BelongsTo {
        return $this->belongsTo(PreProduction::class);
    }
}
