<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPerusahaanController extends Controller
{
    public function index()
    {
        // Mengambil data perusahaan berdasarkan username user yang sedang login
        $perusahaanLogin = Perusahaan::where('username', Auth::user()->username)->first();
        $alumniLogin = Alumni::where('username', Auth::user()->username)->first();

        // Menghitung jumlah alumni dan perusahaan
        $jumlahAlumni = Alumni::count();
        $jumlahPerusahaan = Perusahaan::count();

        // Mengembalikan tampilan dashboardPerusahaan dengan data yang dibutuhkan
        return view('dashboardPerusahaan', compact('jumlahAlumni', 'jumlahPerusahaan', 'perusahaanLogin', 'alumniLogin'));


    }
}
