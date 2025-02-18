<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="EstimationModel",
 *     title="EstimationModel",
 *     description="Modello che rappresenta una stima delle caratteristiche di una pianta o materiale, inclusi altezza, volume, diametro e parametri associati.",
 *     @OA\Property(property="height", type="float", description="Altezza stimata", example=12.5),
 *     @OA\Property(property="volume", type="float", description="Volume stimato", example=45.7),
 *     @OA\Property(property="double_diameter", type="float", description="Diametro doppio stimato", example=10.2),
 *     @OA\Property(property="mesure", type="string", description="Tipo di misura utilizzata", example="metri"),
 *     @OA\Property(property="formula", type="string", description="Formula utilizzata per il calcolo", example="pi * (diametro/2)^2 * altezza"),
 *     @OA\Property(property="retrurning_parameter", type="string", description="Parametro di ritorno utilizzato per la stima", example="coefficiente di densità"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp di creazione", example="2025-02-18T12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp dell'ultima modifica", example="2025-02-19T12:00:00")
 * )
 */
class EstimationModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'height',
        'volume',
        'double_diameter',
        'mesure',
        'formula',
        'retrurning_parameter'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
