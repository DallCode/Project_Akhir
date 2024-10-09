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
        $request->validate([
            'nama' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB
        ]);

        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logoPath = $logo->storeAs('public/logos', $logoName);
            $logoPath = str_replace('public/', 'storage/', $logoPath);
        }

        $pengguna = User::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => 'Perusahaan',
        ]);

        if ($pengguna) {
            Perusahaan::create([
                'username' => $pengguna->username,
                'nama' => $request->input('nama'),
                'bidang_usaha' => $request->input('bidang_usaha'),
                'no_telepon' => $request->input('no_telepon'),
                'alamat' => $request->input('alamat'),
                'logo' => $logoPath,
            ]);
            return redirect('/dataperusahaan')->with('success', 'Data perusahaan berhasil ditambahkan');
        }
        return redirect()->back()->with('error', 'Gagal menambahkan data perusahaan');
    }
}
