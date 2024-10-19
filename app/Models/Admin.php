<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'data_admin'; // Nama tabel
    protected $primaryKey = 'nip'; // Kolom primary key
    public $incrementing = false; // Primary key tidak auto increment
    public $timestamps = false; // Tidak menggunakan timestamps

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'nip',
        'username',
        'nama_lengkap',
        'jenis_kelamin',
        'alamat',
        'kontak',
        'foto',
        'status',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
