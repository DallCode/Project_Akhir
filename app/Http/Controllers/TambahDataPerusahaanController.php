<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TambahDataPerusahaanController extends Controller
{
    public function index()
    {
        return view('tambahdataperusahaan');
    }

    public function store(Request $request)
    {
        return $request;
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,pnq|max:2048', // Max 2MB
        ]);

        // Menangani upload logo
        $logoPath = $this->uploadImage($request);

        // Menyimpan pengguna baru
        $pengguna = User::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => 'Perusahaan',
        ]);

        if ($pengguna) {
            // Menyimpan data perusahaan
            Perusahaan::create([
                'username' => $pengguna->username,
                'nama' => $request->input('nama'),
                'bidang_usaha' => $request->input('bidang_usaha'),
                'no_telepon' => $request->input('no_telepon'),
                'alamat' => $request->input('alamat'),
                'logo' => $logoPath, // Simpan logoPath ke database
            ]);
            return redirect('/dataperusahaan')->with('success', 'Data perusahaan berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan data perusahaan');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,pnq|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = uniqid(true) . '-' . $file->getClientOriginalName();
            $file->storeAs('images/', $fileName, 'public');

            return $fileName;
        }

        return '';
    }

}
