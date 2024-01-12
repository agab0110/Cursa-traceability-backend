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
        'particle',
        'woody_species',
        'diameter',
        'height',
        'cultivar',
        'propagation',
        'georeferenzial_date',
        'notes',
        'hammered',
        'cutting',
        'cutted',
        'forest_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'georeferenzial_date' => 'datetime',
        'hammered' => 'boolean',
        'cutting' => 'boolean',
        'cutted' => 'boolean',
    ];

    public function forest(): BelongsTo {
        return $this->belongsTo(Forest::class);
    }
}
