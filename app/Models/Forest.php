<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Forest",
 *     title="Forest",
 *     description="Modello che rappresenta una foresta, con informazioni sul nome, città e regione, e le piante ad essa associate.",
 *     @OA\Property(property="name", type="string", description="Nome della foresta", example="Foresta di Pianura"),
 *     @OA\Property(property="city", type="string", description="Città in cui si trova la foresta", example="Venezia"),
 *     @OA\Property(property="region", type="string", description="Regione in cui si trova la foresta", example="Veneto"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp di creazione", example="2025-02-18T12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp dell'ultima modifica", example="2025-02-19T12:00:00"),
 *     @OA\Property(property="plants", type="array", @OA\Items(ref="#/components/schemas/Plant"), description="Lista delle piante associate alla foresta")
 * )
 */
class Forest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'region'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function plants(): HasMany {
        return $this->hasMany(Plant::class);
    }
}
