<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TambahAdminController extends Controller
{
    public function index()
    {
        return view('tambahakunadmin');
    }

    public function create()
    {
        return view('tambahakunadmin');
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:data_admin,nip',
            'username' => 'required|string|unique:data_admin,username',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki Laki,Perempuan',
            'alamat' => 'required|string',
            'kontak' => 'required|string',
            'foto' => 'nullable|string|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Save new user
        $pengguna = User::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => 'Admin BKK',
        ]);

        if ($pengguna) {
            // Save admin data
            Admin::create([
                'nip' => $request->input('nip'),
                'username' => $pengguna->username,
                'nama_lengkap' => $request->input('nama_lengkap'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'alamat' => $request->input('alamat'),
                'kontak' => $request->input('kontak'),
                'foto' => $request->input('foto'),
            ]);

            return redirect('/akunpengguna')->with('success', 'Data admin` berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan akun Admin. Silakan coba lagi.');
    }

    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = uniqid(true) . '-' . $file->getClientOriginalName();
            $file->storeAs('foto-admin', $fileName, 'public');

            return $fileName;
        }

        return '';
    }
}
