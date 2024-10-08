<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Loker;
use Illuminate\Support\Str;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LamaranPerusahaanController extends Controller
{
    public function index()
    {

         // Mendapatkan data perusahaan yang sedang login berdasarkan username
         $perusahaanLogin = Perusahaan::where('username', Auth::user()->username)->first();

        //  // Cek jika perusahaan yang login ada
        //  if (!$perusahaanLogin) {
        //      return redirect()->back()->with('error', 'Perusahaan tidak ditemukan.');
        //  }

         // Memfilter data lamaran berdasarkan id_data_perusahaan dari perusahaan yang sedang login
         $lamaran = Lamaran::with(['alumni', 'loker'])
         ->whereHas('loker', function($query) use ($perusahaanLogin) {
             $query->where('id_data_perusahaan', $perusahaanLogin->id_data_perusahaan);
         })
         ->get();

         // Mengirimkan data perusahaan yang login dan lamaran yang difilter ke view
         return view('lamaranperusahaan', compact('perusahaanLogin', 'lamaran'));
    }

    public function lolos($id_lamaran, Request $request)
    {
        $lamaran = Lamaran::findOrFail($id_lamaran);
        $lamaran->status = 'Lolos Ketahap Selanjutnya';
        $lamaran->save();

        // Simpan pesan ke public folder dengan slug nama alumni
        $fileName = Str::slug($lamaran->alumni->nama) . '_lolos.txt';
        Storage::put('public/pesan_lamaran/' . $fileName, $request->pesan);

        return redirect()->back()->with('success', 'Pelamar lolos ke tahap selanjutnya.');
    }

    // Aksi untuk diterima
    public function diterima($id_lamaran, Request $request)
    {
        $lamaran = Lamaran::findOrFail($id_lamaran);
        $lamaran->status = 'Diterima';
        $lamaran->save();

        // Simpan pesan ke public folder dengan slug nama alumni
        $fileName = Str::slug($lamaran->alumni->nama) . '_diterima.txt';
        Storage::put('public/pesan_lamaran/' . $fileName, $request->pesan);

        return redirect()->back()->with('success', 'Pelamar diterima.');
    }

    // Aksi untuk ditolak
    public function ditolak($id_lamaran, Request $request)
    {
        $lamaran = Lamaran::findOrFail($id_lamaran);
        $lamaran->status = 'Ditolak';
        $lamaran->save();

        // Simpan pesan ke public folder dengan slug nama alumni
        $fileName = Str::slug($lamaran->alumni->nama) . '_ditolak.txt';
        Storage::put('public/pesan_lamaran/' . $fileName, $request->pesan);

        return redirect()->back()->with('success', 'Pelamar ditolak.');
    }

}
