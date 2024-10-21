<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'username';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'username',
        'name',
        'password',
        'role',
    ];

    public function aktivitas(): HasMany
    {
        return $this->hasMany(Aktivitas::class, 'username');
    }

    public function perusahaan(): HasOne
    {
        return $this->hasOne(Perusahaan::class, 'username', 'username');
    }

    public function alumni(): HasOne
    {
        return $this->hasOne(Alumni::class, 'username', 'username');
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'username', 'username');
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
