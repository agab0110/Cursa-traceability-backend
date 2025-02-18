<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="Modello che rappresenta un utente",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="cf", type="string", example="RSSMRA85M01H501Z"),
 *     @OA\Property(property="name", type="string", example="Mario"),
 *     @OA\Property(property="surname", type="string", example="Rossi"),
 *     @OA\Property(property="birth_date", type="string", format="date", example="1985-01-01"),
 *     @OA\Property(property="email", type="string", format="email", example="mario.rossi@example.com"),
 *     @OA\Property(property="role_id", type="integer", example=2),
 *     @OA\Property(property="role", ref="#/components/schemas/Role")
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cf',
        'name',
        'surname',
        'birth_date',
        'email',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];

    public function role(): BelongsTo {
        return $this->belongsTo(Role::class);
    }
}
