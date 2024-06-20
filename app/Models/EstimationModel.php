<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
