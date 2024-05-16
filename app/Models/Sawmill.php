<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sawmill extends Model
{
    use HasFactory;

    public function transports(): HasMany {
        return $this->hasMany(Transport::class);
    }
}
