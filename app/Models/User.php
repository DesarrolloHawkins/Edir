<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_department_id',
        'username',
        'name',
        'surname',
        'password',
        'role',
        'telefono',
        'email',
        'image',
        'seniority_years',
        'seniority_months',
        'holidays_days',
        'inactive',
        'comunidad_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function alertas()
    {
        return $this->belongsToMany(Alertas::class, 'alertas_status', 'user_id', 'alert_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class,'comunidad_id');
    }

    // En App\Models\User.php
    public function alertasNoLeidas()
    {
        return $this->alertas()
            ->where(function ($query) {
                $query->where('alertas_status.status', 0)
                      ->orWhereNull('alertas_status.status');
            })
            ->latest('datetime');
    }

}
