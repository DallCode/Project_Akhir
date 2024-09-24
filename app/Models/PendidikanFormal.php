<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendidikanFormal extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pendidikan_formal';
    protected $primarykey = 'id_riwayat_pendidikan_formal';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($Model) {
            $prefix = 'RPF';
            $lastRecord = self::orderBy('id_riwayat_pendidikan_formal', 'desc')->first();

            $lastNumber = $lastRecord ? intval(substr($lastRecord->id_riwayat_pendidikan_formal, strlen($prefix))) : 0;
            $newNumber = $lastNumber + 1;

            $Model->id_riwayat_pendidikan_formal = $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
        });
    }

    public function alumni () : BelongsTo {
        return $this->belongsTo(Alumni::class, 'nik');
    }
}