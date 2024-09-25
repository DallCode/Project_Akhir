<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Perusahaan;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardadminController extends Controller
{
    public function index()
    {
        // Mengambil data perusahaan dan alumni berdasarkan username user yang sedang login
        $perusahaanLogin = Perusahaan::where('username', Auth::user()->username)->first();
        $alumniLogin = Alumni::where('username', Auth::user()->username)->first();

        // Menghitung jumlah alumni dan perusahaan
        $jumlahAlumni = Alumni::count();
        $jumlahPerusahaan = Perusahaan::count();

        // Menghitung jumlah alumni yang bekerja
        $alumniBekerja = Lamaran::where('status', 'diterima')
        ->distinct('nik')
        ->count('nik');
        // Menghitung jumlah alumni yang belum bekerja
        $alumniBelumBekerja = $jumlahAlumni - $alumniBekerja;


        // Data untuk chart
        $currentYear = date('Y'); // Ambil tahun saat ini
        $companies = Perusahaan::all();
        $data = [];

       foreach ($companies as $company) {
    // Hitung jumlah alumni unik yang melamar ke perusahaan tertentu
    $count = Lamaran::whereHas('loker', function ($query) use ($company) {
        $query->where('id_data_perusahaan', $company->id_data_perusahaan);
    })->groupBy('nik')
      ->count();

    $data[$company->nama] = $count;
}







        $labels = array_keys($data);
        $values = array_values($data);

        // Mengembalikan tampilan dashboardAdmin dengan semua data
        return view('dashboardadmin', [
            'jumlahAlumni' => $jumlahAlumni,
            'jumlahPerusahaan' => $jumlahPerusahaan,
            'alumniBekerja' => $alumniBekerja,
            'alumniBelumBekerja' => $alumniBelumBekerja,
            'perusahaanLogin' => $perusahaanLogin,
            'alumniLogin' => $alumniLogin,
            'labels' => $labels,
            'values' => $values,
            'currentYear' => $currentYear
        ]);
    }
}
