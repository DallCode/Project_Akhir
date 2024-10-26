<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Perusahaan;
use App\Models\Lamaran;
use App\Models\Loker;
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

        // Menghitung jumlah alumni berdasarkan status
        $alumniBekerja = Alumni::where('status', 'Bekerja')->count();
        $alumniBelumBekerja = Alumni::where('status', 'Tidak Bekerja')->count();
        $alumniKuliah = Alumni::where('status', 'kuliah')->count();
        $alumniWirausaha = Alumni::where('status', 'wirausaha')->count();

        // Menghitung jumlah loker dengan status 'Tertunda'
        $ajuanLoker = Loker::where('status', 'Tertunda')->count();

        // // Data untuk bar chart perusahaan
        // $currentYear = date('Y');
        // $companies = Perusahaan::all();
        // $data = [];

        // foreach ($companies as $company) {
        //     // Hitung jumlah alumni unik yang melamar ke perusahaan tertentu
        //     $count = Lamaran::whereHas('loker', function ($query) use ($company) {
        //         $query->where('id_data_perusahaan', $company->id_data_perusahaan);
        //     })
        //         ->groupBy('nik')
        //         ->count();

        //     $data[$company->nama] = $count;
        // }

        // $labels = array_keys($data);
        // $values = array_values($data);

        // Data untuk pie chart status per jurusan
        $departments = ['AK', 'BR', 'DKV', 'MLOG', 'MP', 'RPL', 'TKJ'];
        $statusCounts = [];
        // Data untuk total status pie chart (semua jurusan)
        $totalStatusCounts = [
            'Bekerja' => Alumni::where('status', 'Bekerja')->count(),
            'Belum Bekerja' => Alumni::where('status', 'Tidak Bekerja')->count(),
            'Kuliah' => Alumni::where('status', 'kuliah')->count(),
            'Wirausaha' => Alumni::where('status', 'wirausaha')->count(),
        ];

        foreach ($departments as $dept) {
            $statusCounts[$dept] = [
                'Bekerja' => Alumni::where('jurusan', $dept)
                    ->where('status', 'Bekerja')
                    ->count(),
                'Belum Bekerja' => Alumni::where('jurusan', $dept)
                    ->where('status', 'Tidak Bekerja')
                    ->count(),
                'Kuliah' => Alumni::where('jurusan', $dept)
                    ->where('status', 'kuliah')
                    ->count(),
                'Wirausaha' => Alumni::where('jurusan', $dept)
                    ->where('status', 'wirausaha')
                    ->count(),
            ];
        }

        // Mengembalikan tampilan dashboardAdmin dengan semua data
        return view('dashboardadmin', [
            'jumlahAlumni' => $jumlahAlumni,
            'jumlahPerusahaan' => $jumlahPerusahaan,
            'alumniBekerja' => $alumniBekerja,
            'alumniBelumBekerja' => $alumniBelumBekerja,
            'alumniKuliah' => $alumniKuliah,
            'alumniWirausaha' => $alumniWirausaha,
            'ajuanLoker' => $ajuanLoker,
            'perusahaanLogin' => $perusahaanLogin,
            'alumniLogin' => $alumniLogin,
            // 'labels' => $labels,
            // 'values' => $values,
            // 'currentYear' => $currentYear,
            'statusCounts' => $statusCounts,
            'statusCounts' => $statusCounts,
            'totalStatusCounts' => $totalStatusCounts,
        ]);
    }

    public function getAlumniStats($year)
    {
        $companies = Perusahaan::all();
        $data = [];

        foreach ($companies as $company) {
            // Hitung jumlah alumni yang diterima di perusahaan tertentu untuk tahun yang dipilih
            $count = Lamaran::whereHas('loker', function ($query) use ($company) {
                $query->where('id_data_perusahaan', $company->id_data_perusahaan);
            })
                ->where('status', 'Diterima')
                ->whereYear('waktu', $year)
                ->groupBy('nik')
                ->count();

            if ($count > 0) {  // Hanya tampilkan perusahaan yang memiliki alumni diterima
                $data[$company->nama] = $count;
            }
        }

        // Urutkan data berdasarkan jumlah alumni terbanyak
        arsort($data);

        return response()->json([
            'labels' => array_keys($data),
            'values' => array_values($data)
        ]);
    }
}
