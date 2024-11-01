<?php

namespace App\Http\Controllers;

use Akaunting\Apexcharts\Chart;
use App\Models\Alumni;
use App\Models\Perusahaan;
use App\Models\Lamaran;
use App\Models\Loker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $currentYear = request('year', date('Y'));

        // Get initial data for the current year
        $stats = $this->getAcceptedStats($currentYear);



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
            'statusCounts' => $statusCounts,
            'statusCounts' => $statusCounts,
            'totalStatusCounts' => $totalStatusCounts,
            'currentYear' => $currentYear,
            'labels' => $stats['labels'],
            'values' => $stats['values']
        ]);
    }

    public function getAcceptedStats($year = null)
    {
        $year = $year ?? date('Y');

        // Query untuk mendapatkan top 10 perusahaan dengan lamaran yang diterima
        $topCompanies = Perusahaan::select('data_perusahaan.*')
            ->join('lowongan_pekerjaan', 'data_perusahaan.id_data_perusahaan', '=', 'lowongan_pekerjaan.id_data_perusahaan')
            ->join('lamaran', 'lowongan_pekerjaan.id_lowongan_pekerjaan', '=', 'lamaran.id_lowongan_pekerjaan')
            ->where('lamaran.status', 'Diterima')
            ->whereYear('lamaran.waktu', $year)
            ->groupBy('data_perusahaan.id_data_perusahaan', 'data_perusahaan.nama')
            ->selectRaw('COUNT(DISTINCT lamaran.nik) as accepted_count')
            ->orderByDesc('accepted_count')
            ->limit(10)
            ->get();

        $data = [];
        foreach ($topCompanies as $company) {
            $data[$company->nama] = $company->accepted_count;
        }

        return [
            'labels' => array_keys($data),
            'values' => array_values($data)
        ];
    }
}

