<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileLamaran extends Model
{
    use HasFactory;

    protected $table = 'file_lamaran';
    public $timestamps = false;
    protected $keyType = 'string'; // Pastikan ID adalah string
    protected $guarded = [];
    protected $fillable = ['id_lamaran', 'nama_file', 'created_at', 'updated_at'];

    public function lamaran(): BelongsTo
    {
        return $this->belongsTo(Lamaran::class, 'id_lamaran');
    }
}
