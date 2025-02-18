<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Product",
 *     title="Product",
 *     description="Modello che rappresenta un prodotto all'interno della produzione.",
 *     @OA\Property(property="name", type="string", description="Nome del prodotto", example="Prodotto A"),
 *     @OA\Property(property="production_id", type="integer", description="ID della produzione associata", example=1),
 *     @OA\Property(property="log_number", type="string", description="Numero di log del prodotto", example="LOG123456"),
 *     @OA\Property(property="lot_id", type="string", description="ID del lotto del prodotto", example="LOT987654"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp di creazione", example="2025-02-18T12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp dell'ultima modifica", example="2025-02-19T12:00:00"),
 *     @OA\Property(property="production", ref="#/components/schemas/Production", description="Produzione associata al prodotto")
 * )
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'production_id',
        'log_number',
        'lot_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function production(): BelongsTo {
        return $this->belongsTo(Production::class);
    }
}
