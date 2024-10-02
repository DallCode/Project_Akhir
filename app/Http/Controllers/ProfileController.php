<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\PendidikanFormal;
use App\Models\PendidikanNonFormal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->alumni;
        $formal = PendidikanFormal::where('nik', $user->nik)->get();
        $nonFormal = PendidikanNonFormal::where('nik', $user->nik)->get();

        // Mengembalikan data ke view profile
        return view('profile', compact('user', 'formal', 'nonFormal'));
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

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateAbout(Request $request)
    {
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

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function storePendidikanFormal(Request $request)
    {
        $request->validate([
            'tingkat_pendidikan' => 'required|string|in:SD,SMP,SMA/SMK,Diploma (D1-D4),Sarjana (S1),Magister (S2),Doktor (S3)',
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:100',
            'bidang_studi' => 'nullable|string|max:100',
            'tahun_awal' => 'required|integer|digits:4|before_or_equal:tahun_akhir',
            'tahun_akhir' => 'required|integer|digits:4|after_or_equal:tahun_awal',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        PendidikanFormal::create([
            'nik' => Auth::user()->alumni->nik,
            'tingkat_pendidikan' => $request->tingkat_pendidikan,
            'nama_sekolah' => $request->nama_sekolah,
            'alamat' => $request->alamat,
            'gelar' => $request->gelar,
            'bidang_studi' => $request->bidang_studi,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Pendidikan formal berhasil ditambahkan.');
    }

    public function updatePendidikanFormal(Request $request, $id_riwayat_pendidikan_formal)
    {
        $request->validate([
            'tingkat_pendidikan' => 'required|string|in:SD,SMP,SMA/SMK,DDiploma (D1-D4),Sarjana (S1),Magister (S2),Doktor (S3)',
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:100',
            'bidang_studi' => 'nullable|string|max:100',
            'tahun_awal' => 'required|integer|digits:4|before_or_equal:tahun_akhir',
            'tahun_akhir' => 'required|integer|digits:4|after_or_equal:tahun_awal',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $formal = PendidikanFormal::find($id_riwayat_pendidikan_formal);

        if (!$formal) {
            return redirect()->back()->withErrors('Pendidikan formal tidak ditemukan.');
        }

        $formal->update([
            'tingkat_pendidikan' => $request->tingkat_pendidikan,
            'nama_sekolah' => $request->nama_sekolah,
            'alamat' => $request->alamat,
            'gelar' => $request->gelar,
            'bidang_studi' => $request->bidang_studi,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Pendidikan formal berhasil diperbarui.');
    }

    public function deletePendidikanFormal($id_riwayat_pendidikan_formal)
    {
        $formal = PendidikanFormal::find($id_riwayat_pendidikan_formal);

        if (!$formal) {
            return response()->json(['message' => 'Pendidikan formal tidak ditemukan.'], 404);
        }

        $formal->delete();

        return response()->json(['message' => 'Pendidikan formal berhasil dihapus.']);
    }

    public function getPendidikanFormal($id_riwayat_pendidikan_formal)
    {
        $formal = PendidikanFormal::find($id_riwayat_pendidikan_formal);

        if (!$formal) {
            return response()->json(['message' => 'Pendidikan formal tidak ditemukan.'], 404);
        }

        return response()->json($formal);
    }

    public function storePendidikanNonFormal(Request $request)
{
    $request->validate([
        'nama_lembaga' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'kursus' => 'required|string|max:255',
        'tanggal' => 'required|date',
    ]);

    PendidikanNonFormal::create([
        'nik' => Auth::user()->alumni->nik,
        'nama_lembaga' => $request->nama_lembaga,
        'alamat' => $request->alamat,
        'kursus' => $request->kursus,
        'tanggal' => $request->tanggal,
    ]);

    return redirect()->back()->with('success', 'Pendidikan non-formal berhasil ditambahkan.');
}

public function updatePendidikanNonFormal(Request $request, $id_riwayat_pendidikan_non_formal)
{
    $request->validate([
        'nama_lembaga' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'kursus' => 'required|string|max:255',
        'tanggal' => 'required|date',
    ]);

    $nonFormal = PendidikanNonFormal::find($id_riwayat_pendidikan_non_formal);

    if (!$nonFormal) {
        return redirect()->back()->withErrors('Pendidikan non-formal tidak ditemukan.');
    }

    $nonFormal->update([
        'nama_lembaga' => $request->nama_lembaga,
        'alamat' => $request->alamat,
        'kursus' => $request->kursus,
        'tanggal' => $request->tanggal,
    ]);

    return redirect()->back()->with('success', 'Pendidikan non-formal berhasil diperbarui.');
}

public function deletePendidikanNonFormal($id_riwayat_pendidikan_non_formal)
{
    $nonFormal = PendidikanNonFormal::find($id_riwayat_pendidikan_non_formal);

    if (!$nonFormal) {
        return response()->json(['message' => 'Pendidikan non-formal tidak ditemukan.'], 404);
    }

    $nonFormal->delete();

    return response()->json(['message' => 'Pendidikan non-formal berhasil dihapus.']);
}

public function getPendidikanNonFormal($id_riwayat_pendidikan_non_formal)
{
    $nonFormal = PendidikanNonFormal::find($id_riwayat_pendidikan_non_formal);

    if (!$nonFormal) {
        return response()->json(['message' => 'Pendidikan non-formal tidak ditemukan.'], 404);
    }

    return response()->json($nonFormal);
}



}
