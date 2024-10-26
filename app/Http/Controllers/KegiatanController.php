<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{

    public function  index()
    {
        $kegiatan = Alumni::all();
        return  view('kegiatanalumni', compact('kegiatan'));
    }

    public function updateKegiatan(Request $request)
    {
       // Validasi input
       $request->validate([
        'kegiatanSekarang' => 'required|in:Bekerja,Belum Bekerja,Kuliah,Wirausaha',
        'alasan' => 'nullable|string',
    ]);

    // Ambil user yang sedang login
    $user = Auth::user();

    // Update kegiatan di model Alumni
    $alumni = Alumni::where('nik', $user->alumni->nik)->first();
    $alumni->status = $request->kegiatanSekarang;
    $alumni->save();

    if ($request->filled('alasan')) {
        $alasanFileName = 'alasan_' . $alumni->nik . '.txt';
        Storage::disk('public')->put('alasan/' . $alasanFileName, $request->alasan);
    }


    // Redirect kembali dengan pesan sukses
    return redirect()->back()->with('success', 'Status dan alasan berhasil diperbarui.');
    }
}
