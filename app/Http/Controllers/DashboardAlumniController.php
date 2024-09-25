<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\FileLamaran;
use App\Models\Lamaran;
use App\Models\Loker;
use Illuminate\Support\Facades\Auth;

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
        // ->get();


        return view('dashboardAlumni', compact('alumniLogin', 'Loker'));
    }

    public function store(Request $request)
    {
        $alumniLogin = Alumni::where('username', Auth::user()->username)->first();

        // Ambil loker berdasarkan id_lowongan_pekerjaan dari request
        $loker = Loker::where('id_lowongan_pekerjaan', $request->id_lowongan_pekerjaan)->first();

        // Pastikan bahwa $loker ditemukan sebelum melanjutkan
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
        if ($request->hasFile('file_lamaran')) {
            $file = $request->file('file_lamaran');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files'), $filename);

            $fileLamaran = new FileLamaran();
            $fileLamaran->id_lamaran = $lamaran->id_lamaran;
            $fileLamaran->nama_file = 'files/' . $filename;
            $fileLamaran->save();
        }

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim');
    }
}
