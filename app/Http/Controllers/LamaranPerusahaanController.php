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

        // Memfilter data lamaran berdasarkan id_data_perusahaan dari perusahaan yang sedang login
        $lamaran = Lamaran::with(['alumni', 'loker'])
            ->whereHas('loker', function ($query) use ($perusahaanLogin) {
                $query->where('id_data_perusahaan', $perusahaanLogin->id_data_perusahaan);
            })
            ->whereIn('status', ['Terkirim', 'Lolos Ketahap Selanjutnya'])
            ->get();

        // Mengirimkan data perusahaan yang login dan lamaran yang difilter ke view
        return view('lamaranperusahaan', compact('perusahaanLogin', 'lamaran'));
    }

    public function updateStatus(Request $request, $id)
    {


        // Validasi input status dan alasan
        $request->validate([
            'status' => 'required',
            'alasan' => 'required|string',
        ]);

        // Cari lamaran berdasarkan ID
        $lamaran = Lamaran::findOrFail($id);

        // Update status lamaran
        $lamaran->status = $request->input('status');
        $lamaran->save();

        // Simpan alasan perubahan status ke dalam storage
        $alasan = $request->input('alasan');
        $filename = $id . '_' . $lamaran->alumni->nama . '.txt';
        Storage::put('public/pesan_lamaran/' . $filename, $alasan);

        return back()->with('success', 'Status lamaran berhasil diperbarui!');
    }

    public function arsip()
    {
        // Mendapatkan data perusahaan yang sedang login berdasarkan username
        $perusahaanLogin = Perusahaan::where('username', Auth::user()->username)->first();

        // Memfilter data lamaran berdasarkan id_data_perusahaan dari perusahaan yang sedang login
        $arsip = Lamaran::with(['alumni', 'loker'])
            ->whereHas('loker', function ($query) use ($perusahaanLogin) {
                $query->where('id_data_perusahaan', $perusahaanLogin->id_data_perusahaan);
            })
            ->whereIn('status', ['Diterima', 'Ditolak'])
            ->get();

        return view('arsiplamaran', compact('arsip'));
    }
}
