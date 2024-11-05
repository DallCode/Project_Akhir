<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Alumni extends Model
{
    use HasFactory;
    protected $table = 'data_alumni';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $fillable = ['nik', 'username', 'nama', 'jurusan', 'jenis_kelamin', 'tahun_lulus', 'lokasi' , 'alamat', 'keahlian', 'foto', 'deskripsi', 'status', 'keterangan'];
    public $timestamps = false;

    

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lamaran(): HasMany
    {
        return $this->hasMany(Lamaran::class, 'nik', 'nik');
    }

    public function pendidikanformal()
    {
        return $this->hasMany(PendidikanFormal::class, 'nik', 'nik'); // Sesuaikan nama kolom FK
    }

    public function pendidikannonformal()
    {
        return $this->hasMany(PendidikanNonFormal::class, 'nik', 'nik');
    }

    public function kerja()
    {
        return $this->hasMany(Kerja::class, 'nik', 'nik');
    }
}
