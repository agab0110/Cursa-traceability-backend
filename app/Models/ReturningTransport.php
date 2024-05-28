<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturningTransport extends Model
{
    use HasFactory;

    protected $fillable = [
        'transport_id',
        'notes',
        'returing_date',
        'returned_date'
    ];

    public function transport(): BelongsTo {
        return $this->belongsTo(Transport::class);
    }
}
