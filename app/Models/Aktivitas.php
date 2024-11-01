<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aktivitas extends Model
{
    use HasFactory;
    protected $table = 'aktivitas_users';
    protected $fillable = ['id_aktivitas_user', 'username', 'keterangan', 'created_at'];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
