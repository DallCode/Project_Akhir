<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\Loker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatalokerController extends Controller
{
    public function index()
    {
        // Mendapatkan data perusahaan yang sedang login berdasarkan username
        $perusahaanLogin = Perusahaan::where('username', Auth::user()->username)->first();

        // Memfilter data loker berdasarkan id_data_perusahaan dari perusahaan yang sedang login
        $loker = Loker::where('id_data_perusahaan', $perusahaanLogin->id_data_perusahaan)->get();

        // Mengirimkan data perusahaan yang login dan loker yang difilter ke view
        return view('dataLoker', compact('perusahaanLogin', 'loker'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'jenis_waktu_pekerjaan' => 'required',
            'tanggal_akhir' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $loker = Loker::create([
            'id_data_perusahaan' => Auth::user()->perusahaan->id_data_perusahaan,
            'jabatan' => $request->jabatan,
            'jenis_waktu_pekerjaan' => $request->jenis_waktu_pekerjaan,
            'deskripsi' => $request->deskripsi,
            'tanggal_akhir' => $request->tanggal_akhir,
            'status' => 'Tertunda',
            'waktu' => Carbon::now(),
        ]);


        return redirect()->back()->with('success', 'Lowongan pekerjaan berhasil ditambahkan!');
    }


    public function show($id_lowongan_pekerjaan)
    {
        // Dapatkan ID perusahaan yang sedang login (misalnya dari sesi atau autentikasi)
        $id_data_perusahaan = Auth()->user()->perusahaan->id_data_perusahaan; // Sesuaikan dengan cara Anda mendapatkan ID perusahaan

        // Cari lowongan berdasarkan ID dan pastikan juga sesuai dengan ID perusahaan
        $loker = Loker::where('id_lowongan_pekerjaan', $id_lowongan_pekerjaan)
            ->where('id_data_perusahaan', $id_data_perusahaan)
            ->firstOrFail();

        // Jika ditemukan, tampilkan view dengan data lowongan
        return view('lowongan.show', compact('loker'));
    }


    public function update(Request $request, $id_lowongan_pekerjaan)
    {




        $lowongan = Loker::findOrFail($id_lowongan_pekerjaan);

        $lowongan->jabatan = $request->jabatan;
        $lowongan->jenis_waktu_pekerjaan = $request->jenis_waktu_pekerjaan;
        $lowongan->deskripsi = $request->deskripsi;
        $lowongan->tanggal_akhir = $request->tanggal_akhir;
        // $lowongan->status = $request->status;

        $lowongan->save();

        return redirect()->route('lowongan.index')->with('success', 'Data lowongan berhasil diperbarui');
    }
}
