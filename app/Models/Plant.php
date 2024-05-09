<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'hammered_date',
        'cutting_date',
        'cutted_date',
        'notes',
        'hammered',
        'cutting',
        'cutted',
        'forest_id',
        'lot_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'georeferenzial_date' => 'datetime',
        'hammered_date' => 'datetime',
        'cutting_date' => 'datetime',
        'cutted_date' => 'datetime',
        'hammered' => 'boolean',
        'cutting' => 'boolean',
        'cutted' => 'boolean',
    ];

    public function forest(): BelongsTo {
        return $this->belongsTo(Forest::class);
    }

    public function lot(): BelongsTo {
        return $this->belongsTo(Lot::class);
    }
}

// TODO: Provare a fare un filto per bosco sui lotti
