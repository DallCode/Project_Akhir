<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\Loker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjuanlokerController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $perusahaanLogin = Perusahaan::where('username', Auth::user()->username)->first();
        } else {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $loker = Loker::all(); // Mengambil semua data lowongan
        // return view('Lokeradmin', compact('perusahaanLogin', 'loker'));
        return view('Ajuanloker', compact('loker')); // Mengirimkan data ke view
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Dipublikasi,Tidak Dipublikasi',
            'alasan' => 'nullable|string',
        ]);

        $lowongan = Loker::findOrFail($id);
        $oldStatus = $lowongan->status;
        $lowongan->status = $request->status;

        // Simpan alasan ke file jika status diubah menjadi "Tidak Dipublikasi"
        if ($lowongan->status === 'Tidak Dipublikasi') {
            $alasan = $request->input('alasan');
            $filePath = public_path("alasan_lowongan_{$id}.txt");
            file_put_contents($filePath, $alasan);
        } else {
            // Hapus file alasan jika status diubah dari "Tidak Dipublikasi"
            $filePath = public_path("alasan_lowongan_{$id}.txt");
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $lowongan->save();

        return redirect()->back()->with('success', 'Status lowongan berhasil diubah.');
    }
}
