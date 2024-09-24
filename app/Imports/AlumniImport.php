<?php
namespace App\Imports;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumniImport implements ToModel, WithHeadingRow
{
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */

    use Importable;


    public function model(array $row)
    {
        $user = User::create([
            'username' => $row['nik'],
            'password' => bcrypt($row['password']),
            'role' => 'Alumni'
        ]);

        return new Alumni([
            'nik'     => $row['nik'], // Gunakan nama header sesuai dengan file Excel
            'username'   => $user->username,
            'nama'    => $row['nama'],
            'jurusan'   => $row['jurusan'],
            // 'jenis_kelamin' => $row['jenis_kelamin'],
            'tahun_lulus'   => $row['tahun_lulus'],
        ]);
    }
    // public function model(array $row)
    // {
    //    $pengguna = User::create([
    //     'email' => $row['email'],
    //     'password' => Hash::make($row['password']),
    //     'role' => 'Alumni',
    //    ]);

    //    return new Alumni([
    //     'id_pengguna' => $pengguna->id,
    //     'nis' => $row['nis'],
    //     'nama' => $row['nama_lengkap'],
    //     'jurusan' => $row['jurusan'],
    //     'jenis_kelamin' => $row['jenis_kelamin'],
    //     'tahun_lulus' => $row['tahun_lulus']
    //    ]);
    // }
}