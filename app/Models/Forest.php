<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Forest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'region'
    ];

    public function plants(): HasMany {
        return $this->hasMany(Plant::class);
    }
}
