<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PreProduction",
 *     title="PreProduction",
 *     description="Modello che rappresenta la fase preliminare della produzione, collegata a Transport e Production.",
 *     @OA\Property(property="company_name", type="string", description="Nome dell'azienda in fase preliminare", example="XYZ Manufacturing"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp di creazione", example="2025-02-18T12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp dell'ultima modifica", example="2025-02-19T12:00:00"),
 *     @OA\Property(property="transports", type="array", @OA\Items(ref="#/components/schemas/Transport"), description="Lista di trasporti associati alla pre-produzione"),
 *     @OA\Property(property="production", type="array", @OA\Items(ref="#/components/schemas/Production"), description="Lista di produzioni associate alla pre-produzione")
 * )
 */
class PreProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function transports(): HasMany {
        return $this->hasMany(Transport::class);
    }

    public function production(): HasMany {
        return $this->hasMany(Production::class);
    }
}
