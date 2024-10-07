<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KerjaLamaran extends Model
{
    use HasFactory;

    protected $table = 'kerja_lamarans';

    protected $fillable = [
        'id_lamaran', 'perusahaan', 'posisi', 'tahun_masuk', 'tahun_keluar'
    ];
}

