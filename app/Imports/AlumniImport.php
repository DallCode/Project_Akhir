<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AlumniImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        $existingUser = User::where('username', $row['nik'])->first();

        if (!$existingUser) {
            $user = User::create([
                'username' => $row['nik'],
                'password' => Hash::make($row['password']),
                'role' => 'Alumni'
            ]);
        } else {
            $user = $existingUser;
        }

        return new Alumni([
            'nik'     => $row['nik'],
            'username'   => $user->username,
            'nama'    => $row['nama'],
            'jurusan'   => $row['jurusan'],
            'tahun_lulus'   => $row['tahun_lulus'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|unique:data_alumni,nik',
            'nama' => 'required',
            'jurusan' => 'required',
            'tahun_lulus' => 'required|numeric',
            'password' => 'required|min:6',
        ];
    }
}
