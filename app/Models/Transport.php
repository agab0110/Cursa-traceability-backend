<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate',
        'driver',
        'lot_id',
        'shipping',
        'shipping_date',
        'shipped',
        'shipped_date'
    ];

}
