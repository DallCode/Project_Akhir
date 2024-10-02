<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    public function updateKegiatan(Request $request)
    {
        // Validasi input
        $request->validate([
            'kegiatanSekarang' => 'required|in:Bekerja,Tidak Bekerja,Kuliah,Wirausaha',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Update kegiatan di model Alumni atau model terkait
        $alumni = Alumni::where('nik', $user->alumni->nik)->first(); // Sesuaikan dengan relasi model kamu
        $alumni->status = $request->kegiatanSekarang;
        $alumni->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
