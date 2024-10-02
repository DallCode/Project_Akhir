<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class kerja extends Model
{
    use HasFactory;
    protected $table = 'pengalaman_kerja';
    public $timestamps = false;
    protected $fillable = ['id_pengalaman_kerja','nik','jabatan','jenis_waktu_pekerjaan','nama_perusahaan','alamat','tahun_awal','tahun_akhir','deskripsi'];

    public function alumni () : BelongsTo {
        return $this->belongsTo(Alumni::class);
    }

    public static function generateKodeUnik()
    {
        $prefix = 'K-';
        $lastRecord = self::orderBy('id_pengalaman_kerja', 'desc')->first();
        $lastNumber = $lastRecord ? intval(substr($lastRecord->id_pengalaman_kerja, strlen($prefix))) : 0;
        $newNumber = $lastNumber + 1;
        return $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'username');
    // }
}