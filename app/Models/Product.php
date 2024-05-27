<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
