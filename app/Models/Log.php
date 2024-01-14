<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    protected $fillable = [
        'plant_id',
        'lenght',
        'median',
        'cut_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'cut_date' => 'datetime',
    ];

    public function lot(): BelongsTo {
        return $this->belongsTo(Lot::class);
    }
}
