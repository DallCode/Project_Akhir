<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Loker;
use App\Models\Perusahaan;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPerusahaanController extends Controller
{
    public function index()
    {
        // Mengambil data perusahaan berdasarkan username user yang sedang login
        $perusahaanLogin = Perusahaan::where('username', Auth::user()->username)->first();

        // Mengambil semua loker yang terkait dengan perusahaan yang sedang login
        $loker = Loker::where('id_data_perusahaan', $perusahaanLogin->id_data_perusahaan)->get();

        // Menghitung total loker
        $totalLoker = $loker->count();

        // Menghitung jumlah loker yang dipublikasi
        $lokerDipublikasi = $loker->where('status', 'Dipublikasi')->count();

        // Mengambil semua lamaran yang terkait dengan loker dari perusahaan yang sedang login
        $lamaran = Lamaran::whereIn('id_lowongan_pekerjaan', $loker->pluck('id_lowongan_pekerjaan'))->get();

        // Menghitung total lamaran
        $totalLamaran = $lamaran->count();

        // Menghitung jumlah lamaran terbaru (misalnya dalam 7 hari terakhir)
        $lamaranTerbaru = $lamaran->where('waktu', '>=', now()->subDays(7))->count();

        // Data per tahun dan per bulan
        $lokerPerBulan = Loker::where('id_data_perusahaan', $perusahaanLogin->id_data_perusahaan)
            ->selectRaw('YEAR(waktu) as year, MONTH(waktu) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->get();

        $lamaranPerBulan = Lamaran::whereIn('id_lowongan_pekerjaan', $loker->pluck('id_lowongan_pekerjaan'))
            ->selectRaw('YEAR(waktu) as year, MONTH(waktu) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->get();

        $statusLamaran = Lamaran::whereIn('id_lowongan_pekerjaan', $loker->pluck('id_lowongan_pekerjaan'))
            ->selectRaw('YEAR(waktu) as year, id_lowongan_pekerjaan, COUNT(*) as total, SUM(status = "Diterima") as accepted')
            ->groupBy('year', 'id_lowongan_pekerjaan')
            ->get();


        // Mengembalikan tampilan dashboardPerusahaan dengan data yang dibutuhkan
        return view('dashboardPerusahaan', compact(
            'perusahaanLogin',
            'totalLoker',
            'lokerDipublikasi',
            'totalLamaran',
            'lamaranTerbaru',
            'lokerPerBulan',
            'lamaranPerBulan',
            'statusLamaran'
        ));
    }
}
