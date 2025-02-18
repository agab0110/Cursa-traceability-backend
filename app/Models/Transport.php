<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Transport",
 *     title="Transport",
 *     description="Modello che rappresenta un trasporto",
 *     @OA\Property(property="id", type="integer", description="ID del trasporto", example=1),
 *     @OA\Property(property="plate", type="string", description="Targa del veicolo", example="AB123CD"),
 *     @OA\Property(property="driver", type="string", description="Nome dell'autista", example="Mario Rossi"),
 *     @OA\Property(property="company", type="string", description="Nome dell'azienda di trasporti", example="Trasporti SRL"),
 *     @OA\Property(property="lot_id", type="integer", example=5),
 *     @OA\Property(property="pre_production_id", type="integer", example=3),
 *     @OA\Property(property="production_id", type="integer", example=2),
 *     @OA\Property(property="shipping", type="boolean", example=true),
 *     @OA\Property(property="shipping_date", type="string", format="date-time", example="2024-02-18T10:00:00Z"),
 *     @OA\Property(property="shipped", type="boolean", example=false),
 *     @OA\Property(property="shipped_date", type="string", format="date-time", example="2024-02-19T10:00:00Z"),
 *     @OA\Property(property="lots", type="array", @OA\Items(ref="#/components/schemas/Lot")),
 *     @OA\Property(property="pre_production", ref="#/components/schemas/PreProduction"),
 *     @OA\Property(property="production", ref="#/components/schemas/Production")
 * )
 */
class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate',
        'driver',
        'company',
        'lot_id',
        'pre_production_id',
        'production_id',
        'shipping',
        'shipping_date',
        'shipped',
        'shipped_date',
    ];

    protected $casts = [
        'shipping_date' => 'datetime',
        'shipped_date' => 'datetime',
    ];

    public function lots(): HasMany {
        return $this->hasMany(Lot::class);
    }

    public function preProduction(): BelongsTo {
        return $this->belongsTo(PreProduction::class);
    }

    public function production(): BelongsTo {
        return $this->belongsTo(Production::class);
    }
}
