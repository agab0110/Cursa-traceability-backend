<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturningTransports extends Model
{
    use HasFactory;

    protected $fillable = [
        'transport_id',
        'notes',
        'returing_date',
        'returned_date'
    ];
}
