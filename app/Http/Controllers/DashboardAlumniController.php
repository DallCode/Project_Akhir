<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\FileLamaran;
use App\Models\KerjaLamaran;
use App\Models\Lamaran;
use App\Models\Loker;
use App\Models\PendidikanLamaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardalumniController extends Controller
{
    public function index(Request $request)
    {
        $alumniLogin = Alumni::where('username', Auth::user()->username)->first();

        $query = request()->query('search'); // Mengambil query pencarian dari request

        $Loker = Loker::where('status', 'Dipublikasi')
            ->when($query, function ($queryBuilder) use ($query) {
                // Filter berdasarkan jabatan dan nama perusahaan
                $queryBuilder->where(function ($q) use ($query) {
                    $q->where('jabatan', 'like', "%{$query}%")
                        ->orWhereHas('perusahaan', function ($q) use ($query) {
                            $q->where('nama', 'like', "%{$query}%");
                        });
                });
            })
            ->with('perusahaan') // Eager load perusahaan untuk menghindari N+1 query
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
        $lamaran->nama = $alumniLogin->nama;
        $lamaran->jenis_kelamin = $alumniLogin->jenis_kelamin;
        $lamaran->lokasi = $alumniLogin->lokasi;
        $lamaran->alamat = $alumniLogin->alamat;
        $lamaran->kontak = $alumniLogin->kontak;
        $lamaran->keahlian = $alumniLogin->keahlian;
        $lamaran->foto = $alumniLogin->foto;
        $lamaran->deskripsi = $alumniLogin->deskripsi;
        $lamaran->save();

        // Simpan riwayat pendidikan formal
        foreach ($alumniLogin->pendidikanformal as $pendidikan) {
            $pendidikanLamaran = new PendidikanLamaran();
            $pendidikanLamaran->id_lamaran = $lamaran->id_lamaran;
            $pendidikanLamaran->institusi = $pendidikan->institusi;
            $pendidikanLamaran->jurusan = $pendidikan->jurusan;
            $pendidikanLamaran->tahun_masuk = $pendidikan->tahun_masuk;
            $pendidikanLamaran->tahun_lulus = $pendidikan->tahun_lulus;
            $pendidikanLamaran->save();
        }

        // Simpan pengalaman kerja
        foreach ($alumniLogin->kerja as $pengalaman) {
            $kerjaLamaran = new KerjaLamaran();
            $kerjaLamaran->id_lamaran = $lamaran->id_lamaran;
            $kerjaLamaran->perusahaan = $pengalaman->perusahaan;
            $kerjaLamaran->posisi = $pengalaman->posisi;
            $kerjaLamaran->tahun_masuk = $pengalaman->tahun_masuk;
            $kerjaLamaran->tahun_keluar = $pengalaman->tahun_keluar;
            $kerjaLamaran->save();
        }

        // Simpan file lamaran jika ada (opsional)
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files'), $filename);

            $fileLamaran = new FileLamaran();
            $fileLamaran->id_lamaran = $lamaran->id_lamaran;
            $fileLamaran->nama_file = 'files/' . $filename;
            $fileLamaran->save();
        }

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim');
    }
    public function uploadLamaran(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['message' => 'Tidak ada file yang diunggah.', 'type' => 'danger'], 400);
        }

        $file = $request->file('file');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/lamaran', $fileName);

        return response()->json(['fileName' => $fileName, 'filePath' => $filePath]);
    }
    public function import(Request $request)
    {
        $fileNames = $request->input('files');

        if (empty($fileNames)) {
            return response()->json(['message' => 'Tidak ada file yang diimpor.', 'type' => 'danger'], 400);
        }

        return response()->json(['message' => 'File berhasil diimpor.', 'type' => 'success']);
    }
}
