<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamaran';
    public $timestamps = false;

    // Pastikan nama property ini benar
    protected $primaryKey = 'id_lamaran'; // Ganti 'primarykey' menjadi 'primaryKey'
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id_lamaran', 'id_lowongan_pekerjaan', 'nik', 'status'];

    public function loker(): BelongsTo {
        return $this->belongsTo(Loker::class, 'id_lowongan_pekerjaan');
    }

    public function alumni(): BelongsTo {
        return $this->belongsTo(Alumni::class, 'nik', 'nik');
    }

    public static function generateKodeUnik()
    {
        $prefix = 'L-'; // Bisa disesuaikan sesuai kebutuhan
        $lastRecord = self::orderBy('id_lamaran', 'desc')->first();
        $lastNumber = $lastRecord ? intval(substr($lastRecord->id_lamaran, strlen($prefix))) : 0;
        $newNumber = $lastNumber + 1;

        return $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
}
