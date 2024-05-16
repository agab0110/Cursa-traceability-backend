<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class Log extends Model
{
    use HasCompositeKey;

    protected $primaryKey = [
        'number',
        'lot_id'
    ];

    public $incrementing = false;

    protected $keyType = 'integer';

    protected $fillable = [
        'number',
        'lot_id',
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
