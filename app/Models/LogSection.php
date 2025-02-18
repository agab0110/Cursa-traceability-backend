<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="LogSection",
 *     title="LogSection",
 *     description="Modello che rappresenta una sezione di un log associato a un lotto.",
 *     @OA\Property(property="lot_id", type="integer", description="ID del lotto associato alla sezione del log", example=1),
 *     @OA\Property(property="log_number", type="string", description="Numero del log", example="LOG123456"),
 *     @OA\Property(property="section", type="string", description="Nome o identificatore della sezione", example="Sezione A"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp di creazione", example="2025-02-18T12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp dell'ultima modifica", example="2025-02-19T12:00:00"),
 *     @OA\Property(property="logs", ref="#/components/schemas/Log", description="Log associato alla sezione")
 * )
 */
class LogSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'log_number',
        'section'
    ];

    protected $hidden = [
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function logs(): BelongsTo {
        return $this->belongsTo(Log::class);
    }
}
