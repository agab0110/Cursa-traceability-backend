<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ReturningTransport",
 *     title="ReturningTransport",
 *     @OA\Property(property="transport_id", type="integer", description="ID del trasporto", example=1),
 *     @OA\Property(property="notes", type="string", description="Note relative al trasporto", example="Trasporto ritardato"),
 *     @OA\Property(property="returing_date", type="string", format="date", description="Data di ritorno prevista", example="2025-02-18"),
 *     @OA\Property(property="returned_date", type="string", format="date", description="Data effettiva di ritorno", example="2025-02-18")
 * )
 */
class ReturningTransport extends Model
{
    use HasFactory;

    protected $fillable = [
        'transport_id',
        'notes',
        'returing_date',
        'returned_date'
    ];

    public function transport(): BelongsTo {
        return $this->belongsTo(Transport::class);
    }
}
