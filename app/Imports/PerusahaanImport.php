<?php

namespace App\Imports;

use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PerusahaanImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        // Cek apakah user perusahaan sudah ada
        $existingUser = User::where('username', $row['email'])->first();

        if (!$existingUser) {
            $user = User::create([
                'username' => $row['email'],
                'password' => Hash::make('perusahaan123'), // Password default
                'role' => 'Perusahaan'
            ]);
        } else {
            $user = $existingUser;
        }

        // Membuat data perusahaan baru
        return new Perusahaan([
            'id_data_perusahaan' => Perusahaan::generateKodeUnik(),
            'username' => $user->username,
            'nama' => $row['nama_perusahaan'],
            'bidang_usaha' => $row['bidang_usaha'],
            'no_telepon' => $row['no_telepon'],
            'alamat' => $row['alamat'],
            'provinsi' => $row['provinsi'],
            'kota' => $row['kota'],
            'kecamatan' => $row['kecamatan'],
            'kelurahan' => $row['kelurahan'],
        ]);
    }

    public function rules(): array
    {
        return [
            'email' => 'required|unique:data_perusahaan,username',
            'nama_perusahaan' => 'required',
            'bidang_usaha' => 'required',
            'no_telepon' => 'required|numeric',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
        ];
    }
}
