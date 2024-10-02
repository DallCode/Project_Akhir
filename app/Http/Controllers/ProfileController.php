<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\kerja;
use App\Models\PendidikanFormal;
use App\Models\PendidikanNonFormal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->alumni;
        $formal = PendidikanFormal::where('nik', $user->nik)->get();
        $nonFormal = PendidikanNonFormal::where('nik', $user->nik)->get();
        $skill = Alumni::where('nik', $user->nik)->get();
        $kerja = Kerja::where('nik', $user->nik)->get();


        return view('profile', compact('user', 'formal', 'nonFormal', 'skill', 'kerja'));
    }

    // untuk Profile dasar
    public function update(Request $request)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'lokasi' => 'required|string|max:225',
        ]);


        $user = Alumni::where('nik', Auth::user()->alumni->nik)->first();


        if (!$user) {
            return redirect()->back()->withErrors('Pengguna tidak ditemukan.');
        }


        $user->nama = $request->nama;
        $user->kontak = $request->kontak;
        $user->alamat = $request->alamat;
        $user->lokasi = $request->lokasi;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    // untuk Tentang saya
    public function updateAbout(Request $request)
    {

        $request->validate([
            'deskripsi' => 'required|string|max:500',
        ]);


        $user = Alumni::where('nik', Auth::user()->alumni->nik)->first();


        if (!$user) {
            return redirect()->back()->withErrors('Pengguna tidak ditemukan.');
        }


        $user->deskripsi = $request->deskripsi;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    // untuk Pendidikan Formal
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


    // untuk Pendidikan Non Formal
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

    //untul Keahlian
    public function storeSkill(Request $request)
    {
        $request->validate([
            'keahlian' => 'required|string|max:255',
        ]);


        $alumni = Alumni::where('nik', auth()->user()->alumni->nik)->first();

        if (!$alumni) {
            return redirect()->back()->withErrors('Data alumni tidak ditemukan.');
        }


        $alumni->update([
            'keahlian' => $request->keahlian,
        ]);

        return redirect()->back()->with('success', 'Keahlian berhasil ditambahkan.');
    }
    public function updateSkill(Request $request, $nik)
    {
        $request->validate([
            'keahlian' => 'required|string|max:255',
        ]);


        $alumni = Alumni::where('nik', $nik)->first();

        if (!$alumni) {
            return redirect()->back()->withErrors('Keahlian tidak ditemukan.');
        }


        $alumni->update([
            'keahlian' => $request->keahlian,
        ]);

        return redirect()->back()->with('success', 'Keahlian berhasil diperbarui.');
    }
    public function deleteSkill($nik)
    {

        $alumni = Alumni::where('nik', $nik)->first();

        if (!$alumni) {
            return response()->json(['message' => 'Keahlian tidak ditemukan.'], 404);
        }


        $alumni->update([
            'keahlian' => null,
        ]);

        return response()->json(['message' => 'Keahlian berhasil dihapus.']);
    }
    public function getSkill($nik)
    {

        $alumni = Alumni::where('nik', $nik)->first();

        if (!$alumni) {
            return response()->json(['message' => 'Keahlian tidak ditemukan.'], 404);
        }

        return response()->json($alumni);
    }

    //untuk Pengalaman Kerja
    public function storePengalamanKerja(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'jenis_waktu_pekerjaan' => 'required|string|in:Waktu Kerja Standar (Full-Time),Waktu Kerja Paruh Waktu (Part-Time),Waktu Kerja Fleksibel (Flexible Hours),Shift Kerja (Shift Work),Waktu Kerja Bergilir (Rotating Shifts),Waktu Kerja Jarak Jauh (Remote Work),Waktu Kerja Kontrak (Contract Work),Waktu Kerja Proyek (Project-Based Work),Waktu Kerja Tidak Teratur (Irregular Hours),Waktu Kerja Sementara (Temporary Work)',
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tahun_awal' => 'required|integer|digits:4|before_or_equal:tahun_akhir',
            'tahun_akhir' => 'required|integer|digits:4|after_or_equal:tahun_awal',
            'deskripsi' => 'nullable|string|max:500',
        ]);
       
        Kerja::create([
            'id_pengalaman_kerja' => Kerja::generateKodeUnik(),
            'nik' => Auth::user()->alumni->nik,
            'jabatan' => $request->jabatan,
            'jenis_waktu_pekerjaan' => $request->jenis_waktu_pekerjaan,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
            'deskripsi' => $request->deskripsi,
        ]);
    
        return redirect()->back()->with('success', 'Pengalaman kerja berhasil ditambahkan.');
    }
    public function updatePengalamanKerja(Request $request, $id_pengalaman_kerja)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'jenis_waktu_pekerjaan' => 'required|string|in:Waktu Kerja Standar (Full-Time),Waktu Kerja Paruh Waktu (Part-Time),Waktu Kerja Fleksibel (Flexible Hours),Shift Kerja (Shift Work),Waktu Kerja Bergilir (Rotating Shifts),Waktu Kerja Jarak Jauh (Remote Work),Waktu Kerja Kontrak (Contract Work),Waktu Kerja Proyek (Project-Based Work),Waktu Kerja Tidak Teratur (Irregular Hours),Waktu Kerja Sementara (Temporary Work)',
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tahun_awal' => 'required|integer|digits:4|before_or_equal:tahun_akhir',
            'tahun_akhir' => 'required|integer|digits:4|after_or_equal:tahun_awal',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $kerja = Kerja::find($id_pengalaman_kerja);

        if (!$kerja) {
            return redirect()->back()->withErrors('Pengalaman kerja tidak ditemukan.');
        }

        $kerja->update([
            'jabatan' => $request->jabatan,
            'jenis_waktu_pekerjaan' => $request->jenis_waktu_pekerjaan,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Pengalaman kerja berhasil diperbarui.');
    }
    public function deletePengalamanKerja($id_pengalaman_kerja)
    {
        $kerja = Kerja::find($id_pengalaman_kerja);

        if (!$kerja) {
            return response()->json(['message' => 'Pengalaman kerja tidak ditemukan.'], 404);
        }

        $kerja->delete();

        return response()->json(['message' => 'Pengalaman kerja berhasil dihapus.']);
    }
    public function getPengalamanKerja($id_pengalaman_kerja)
    {
        $kerja = Kerja::find($id_pengalaman_kerja);

        if (!$kerja) {
            return response()->json(['message' => 'Pengalaman kerja tidak ditemukan.'], 404);
        }

        return response()->json($kerja);
    }
}
