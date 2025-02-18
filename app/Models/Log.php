<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Thiagoprz\CompositeKey\HasCompositeKey;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Log",
 *     title="Log",
 *     description="Modello che rappresenta un log associato a un lotto, comprendente informazioni relative a lunghezza, media e data di taglio.",
 *     @OA\Property(property="number", type="integer", description="Numero identificativo del log", example=123),
 *     @OA\Property(property="lot_id", type="integer", description="ID del lotto a cui il log è associato", example=1),
 *     @OA\Property(property="lenght", type="integer", description="Lunghezza del log", example=100),
 *     @OA\Property(property="median", type="float", description="Media associata al log", example=50.5),
 *     @OA\Property(property="cut_date", type="string", format="date-time", description="Data del taglio", example="2025-02-18T12:00:00"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp di creazione", example="2025-02-18T12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp dell'ultima modifica", example="2025-02-19T12:00:00"),
 *     @OA\Property(property="lot", ref="#/components/schemas/Lot", description="Lotto associato al log"),
 *     @OA\Property(property="log_sections", type="array", @OA\Items(ref="#/components/schemas/LogSection"), description="Lista delle sezioni del log")
 * )
 */
class Log extends Model
{
    use HasCompositeKey;

    protected $primaryKey = [
        'number',
        'lot_id'
    ];

    public $incrementing = false;

    protected $keyType = 'integer';

    protected $fillable = [
        'number',
        'lot_id',
        'lenght',
        'median',
        'cut_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'cut_date' => 'datetime',
    ];

    public function lot(): BelongsTo {
        return $this->belongsTo(Lot::class);
    }

    public function log_sections(): HasMany {
        return $this->hasMany(LogSection::class);
    }
}
