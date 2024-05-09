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

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function plants(): HasMany {
        return $this->hasMany(Plant::class);
    }
}
