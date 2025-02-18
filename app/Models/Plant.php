<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *     schema="Plant",
 *     title="Plant",
 *     description="Modello che rappresenta una pianta",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="lat", type="number", format="float", example=45.123456),
 *     @OA\Property(property="lng", type="number", format="float", example=12.654321),
 *     @OA\Property(property="particle", type="string", example="ABC123"),
 *     @OA\Property(property="woody_species", type="string", example="Quercia"),
 *     @OA\Property(property="diameter", type="number", format="float", example=30.5),
 *     @OA\Property(property="height", type="number", format="float", example=12.4),
 *     @OA\Property(property="cultivar", type="string", example="Frantoio"),
 *     @OA\Property(property="propagation", type="string", example="Innesto"),
 *     @OA\Property(property="georeferenzial_date", type="string", format="date-time", example="2024-02-18T10:00:00Z"),
 *     @OA\Property(property="hammered_date", type="string", format="date-time", example="2024-02-19T10:00:00Z"),
 *     @OA\Property(property="cutting_date", type="string", format="date-time", example="2024-02-20T10:00:00Z"),
 *     @OA\Property(property="cutted_date", type="string", format="date-time", example="2024-02-21T10:00:00Z"),
 *     @OA\Property(property="notes", type="string", example="Pianta in buone condizioni"),
 *     @OA\Property(property="hammered", type="boolean", example=true),
 *     @OA\Property(property="cutting", type="boolean", example=false),
 *     @OA\Property(property="cutted", type="boolean", example=false),
 *     @OA\Property(property="forest_id", type="integer", example=2),
 *     @OA\Property(property="lot_id", type="integer", example=5),
 *     @OA\Property(property="forest", ref="#/components/schemas/Forest"),
 *     @OA\Property(property="lot", ref="#/components/schemas/Lot")
 * )
 */
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
