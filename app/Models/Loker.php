<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loker extends Model
{
    use HasFactory;

    protected $table = 'lowongan_pekerjaan';
    protected $primaryKey = 'id_lowongan_pekerjaan';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id_lowongan_pekerjaan',
        'id_data_perusahaan',
        'jabatan',
        'alamat',
        'jenis_waktu_pekerjaan',
        'deskripsi',
        'tanggal_akhir',
        'status',
        'waktu'
    ];

    public function perusahaan() : BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'id_data_perusahaan');
    }

    public function lamaran() : HasMany
    {
        return $this->hasMany(Lamaran::class, 'id_lowongan_pekerjaan');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_lowongan_pekerjaan = self::generateKodeUnik();
        });
    }

    private static function generateKodeUnik()
    {
        $prefix = 'LP-'; // Bisa disesuaikan sesuai kebutuhan
        $lastRecord = self::orderBy('id_lowongan_pekerjaan', 'desc')->first();
        $lastNumber = $lastRecord ? intval(substr($lastRecord->id_lowongan_pekerjaan, strlen($prefix))) : 0;
        $newNumber = $lastNumber + 1;

        return $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
}