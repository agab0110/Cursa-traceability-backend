<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PreProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function transports(): HasMany {
        return $this->hasMany(Transport::class);
    }

    public function production(): HasMany {
        return $this->hasMany(Production::class);
    }
}
