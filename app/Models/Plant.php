<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [     // TODO: aggiungere tag NFC
        'lat',
        'lng',
        'woods',
        'particle',
        'woody_species',
        'diameter',
        'height',
        'cultivar',
        'propagation',
        'georeferenzial_date',
        'notes',
        'hammered'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'georeferenzial_date' => 'datetime',
        'hammered' => 'boolean'
    ];

    public function forest(): BelongsTo {
        return $this->belongsTo(Forest::class);
    }
}
