<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'log_number',
        'section'
    ];

    protected $hidden = [
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function logs(): BelongsTo {
        return $this->belongsTo(Log::class);
    }
}
