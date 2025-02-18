<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Lot",
 *     title="Lot",
 *     description="Modello che rappresenta un lotto, associato a un impianto, trasporto e log.",
 *     @OA\Property(property="plant_id", type="integer", description="ID della pianta associata al lotto", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp di creazione", example="2025-02-18T12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp dell'ultima modifica", example="2025-02-19T12:00:00"),
 *     @OA\Property(property="plant", ref="#/components/schemas/Plant", description="Impianto associato al lotto"),
 *     @OA\Property(property="logs", type="array", @OA\Items(ref="#/components/schemas/Log"), description="Lista dei log associati al lotto"),
 *     @OA\Property(property="transport", ref="#/components/schemas/Transport", description="Trasporto associato al lotto")
 * )
 */
class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function plant(): HasOne {
        return $this->hasOne(Plant::class);
    }

    public function logs(): HasMany {
        return $this->hasMany(Log::class, 'lot_id');
    }

    public function transport(): BelongsTo {
        return $this->belongsTo(Transport::class);
    }
}
