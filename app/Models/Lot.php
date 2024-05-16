<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function plant(): HasOne {
        return $this->hasOne(Plant::class);
    }

    public function logs(): HasMany {
        return $this->hasMany(Log::class, 'lot_id');
    }
}
