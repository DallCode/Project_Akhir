<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'data_perusahaan';
    protected $primaryKey = 'id_data_perusahaan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_data_perusahaan',
        'username',
        'nama',
        'bidang_usaha',
        'no_telepon',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'logo',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_data_perusahaan)) {
                $model->id_data_perusahaan = self::generateKodeUnik();
            }
            if (empty($model->status)) {
                $model->status = 'Aktif';
            }
        });
    }

    public static function generateKodeUnik()
    {
        $prefix = 'P';
        $lastRecord = self::orderBy('id_data_perusahaan', 'desc')->first();
        $lastNumber = $lastRecord ? intval(substr($lastRecord->id_data_perusahaan, strlen($prefix))) : 0;
        $newNumber = $lastNumber + 1;

        return $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
