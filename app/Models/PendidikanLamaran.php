<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendidikanLamaran extends Model
{
    use HasFactory;

    protected $table = 'pendidikan_lamarans';

    protected $fillable = [
        'id_lamaran', 'institusi', 'jurusan', 'tahun_masuk', 'tahun_lulus'
    ];
}
