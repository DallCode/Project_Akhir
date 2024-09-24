<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perusahaan extends Model
{
    use HasFactory;
    protected $table = 'data_perusahaan';
    protected $primaryKey = 'id_data_perusahaan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'username',
        'nama',
        'bidang_usaha',
        'no_telepon',
        'alamat',
        'logo',
        'status'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_data_perusahaan = self::generateKodeUnik();
        });
    }

    private static function generateKodeUnik()
    {
        $prefix = 'P'; // Bisa disesuaikan sesuai kebutuhan
        $lastRecord = self::orderBy('id_data_perusahaan', 'desc')->first();
        $lastNumber = $lastRecord ? intval(substr($lastRecord->id_data_perusahaan, strlen($prefix))) : 0;
        $newNumber = $lastNumber + 1;

        return $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'username');
    }
}