<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendidikanNonFormal extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pendidikan_non_formal';
    protected $primaryKey = 'id_riwayat_pendidikan_non_formal';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($Model) {
            $prefix = 'RPNF-';
            $lastRecord = self::orderBy('id_riwayat_pendidikan_non_formal', 'desc')->first();

            $lastNumber = $lastRecord ? intval(substr($lastRecord->id_riwayat_pendidikan_non_formal, strlen($prefix))) : 0;
            $newNumber = $lastNumber + 1;

            $Model->id_riwayat_pendidikan_non_formal = $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
        });
    }

    public function alumni () : BelongsTo {
        return $this->belongsTo(Alumni::class, 'nik');
    }
}
