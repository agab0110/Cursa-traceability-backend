<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Production",
 *     title="Production",
 *     description="Modello che rappresenta la produzione, collegato a PreProduction, Transport e Product.",
 *     @OA\Property(property="company_name", type="string", description="Nome dell'azienda", example="ABC Manufacturing"),
 *     @OA\Property(property="pre_production_id", type="integer", description="ID della produzione preliminare associata", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp di creazione", example="2025-02-18T12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp dell'ultima modifica", example="2025-02-19T12:00:00"),
 *     @OA\Property(property="transports", type="array", @OA\Items(ref="#/components/schemas/Transport"), description="Lista di trasporti associati alla produzione"),
 *     @OA\Property(property="products", type="array", @OA\Items(ref="#/components/schemas/Product"), description="Lista di prodotti associati alla produzione")
 * )
 */
class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function preProduction(): BelongsTo {
        return $this->belongsTo(PreProduction::class);
    }

    public function transports(): HasMany {
        return $this->hasMany(Transport::class);
    }

    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }
}
