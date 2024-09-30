<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\PendidikanFormal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
{
    $user = Auth::user()->alumni;
    $formal = PendidikanFormal::where('nik', $user->nik)->get();

    // Mengembalikan data ke view profile
    return view('profile', compact('user', 'formal'));
}


    public function updateAbout(Request $request)
    {
        //
        // Validasi deskripsi
        $request->validate([
            'deskripsi' => 'required|string|max:500',
        ]);

        // Ambil pengguna berdasarkan nik
        $user = Alumni::where('nik', Auth::user()->alumni->nik)->first();

        // Cek apakah pengguna ditemukan
        if (!$user) {
            return redirect()->back()->withErrors('Pengguna tidak ditemukan.');
        }

        // Update deskripsi di database
        $user->deskripsi = $request->deskripsi;
        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diperbarui.');
    }

    public function update(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'lokasi' => 'required|string|max:225',
        ]);

        // Ambil pengguna berdasarkan nik
        $user = Alumni::where('nik', Auth::user()->alumni->nik)->first();

        // Cek apakah pengguna ditemukan
        if (!$user) {
            return redirect()->back()->withErrors('Pengguna tidak ditemukan.');
        }

        // Update data pengguna
        $user->nama = $request->nama;
        $user->kontak = $request->kontak;
        $user->alamat = $request->alamat;
        $user->lokasi = $request->lokasi;
        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diperbarui.');
    }

}
