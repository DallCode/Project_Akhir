<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\FileLamaran;
use App\Models\Lamaran;
use App\Models\Loker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardalumniController extends Controller
{
    public function index(Request $request)
    {
        $alumniLogin = Alumni::where('username', Auth::user()->username)->first();

        $query = request()->query('search');

        $Loker = Loker::where('status', 'Dipublikasi')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($q) use ($query) {
                    $q->where('jabatan', 'like', "%{$query}%")
                        ->orWhereHas('perusahaan', function ($q) use ($query) {
                            $q->where('nama', 'like', "%{$query}%");
                        });
                });
            })
            ->with('perusahaan')
            ->paginate(10);

        return view('dashboardAlumni', compact('alumniLogin', 'Loker'));
    }

    public function store(Request $request)
    {
        $alumniLogin = Alumni::where('username', Auth::user()->username)
            ->with(['pendidikanformal', 'pendidikannonformal', 'kerja'])
            ->first();

        // Validasi kelengkapan profil
        if (
            !$alumniLogin || !$alumniLogin->nama || !$alumniLogin->jenis_kelamin || !$alumniLogin->lokasi ||
            !$alumniLogin->alamat || !$alumniLogin->kontak || !$alumniLogin->keahlian ||
            !$alumniLogin->foto || !$alumniLogin->deskripsi ||
            $alumniLogin->pendidikanformal->isEmpty() || $alumniLogin->kerja->isEmpty()
        ) {
            return redirect()->back()->with('error', 'Profil Anda belum lengkap. Harap lengkapi profil sebelum melamar.');
        }

        // Ambil loker berdasarkan id_lowongan_pekerjaan dari request
        $loker = Loker::where('id_lowongan_pekerjaan', $request->id_lowongan_pekerjaan)->first();

        if (!$loker) {
            return redirect()->back()->with('error', 'Lowongan pekerjaan tidak ditemukan');
        }

        // Simpan data lamaran
        $lamaran = new Lamaran();
        $lamaran->id_lamaran = Lamaran::generateKodeUnik();
        $lamaran->id_lowongan_pekerjaan = $loker->id_lowongan_pekerjaan;
        $lamaran->nik = $alumniLogin->nik;
        $lamaran->status = 'terkirim';
        $lamaran->save();

        // Simpan file lamaran jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/files', $filename); // Simpan ke direktori storage

            $fileLamaran = new FileLamaran();
            $fileLamaran->id_lamaran = $lamaran->id_lamaran;
            $fileLamaran->nama_file = $filename;
            $fileLamaran->file_path = $filePath;
            $fileLamaran->save();
        }

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim');
    }

    public function uploadLamaran(Request $request)
    {
        if (!$request->hasFile('filelamar')) {
            return response()->json(['message' => 'Tidak ada file yang diunggah.', 'type' => 'danger'], 400);
        }

        $filelamars = $request->file('filelamar');
        $filePaths = [];

        // Proses setiap file yang diunggah
        foreach ($filelamars as $file) {
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/lamaran', $fileName);
            $filePaths[] = ['fileName' => $fileName, 'filePath' => $filePath];

            // Simpan ke database
            $fileLamaran = new FileLamaran();
            $fileLamaran->id_lamaran = $request->id_lamaran; // Pastikan id_lamaran dikirimkan di request
            $fileLamaran->nama_file = $fileName;
            $fileLamaran->file_path = $filePath;
            $fileLamaran->save();
        }

        return response()->json(['filePaths' => $filePaths, 'message' => 'File berhasil diunggah.']);
    }

    public function import(Request $request)
    {
        $fileNames = $request->input('files');

        if (empty($fileNames)) {
            return response()->json(['message' => 'Tidak ada file yang diimpor.', 'type' => 'danger'], 400);
        }

        // Implementasikan logika import disini (misal menggunakan Maatwebsite Excel package)

        return response()->json(['message' => 'File berhasil diimpor.', 'type' => 'success']);
    }
}
