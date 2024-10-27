<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Lamaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartAlumniController extends Controller 
{
    public function index()
    {
        $alumniLogin = Alumni::where('username', Auth::user()->username)->first();
        return view('chartalumni', compact('alumniLogin'));
    }

    public function getUserLamaranData(Request $request) 
    {
        $user = auth()->user();
        
        $query = Lamaran::with(['loker' => function($query) {
            $query->with('perusahaan');
        }])
        ->where('nik', $user->nik);

        // Filter berdasarkan bulan jika ada
        if ($request->filled('bulan')) {
            $query->whereMonth('waktu', $request->bulan);
        }

        // Filter berdasarkan tahun jika ada
        if ($request->filled('tahun')) {
            $query->whereYear('waktu', $request->tahun);
        }

        $lamaran = $query->get();

        // Data untuk chart
        $chartData = $lamaran->groupBy('id_lowongan_pekerjaan')->map(function ($group) {
            return [
                'loker' => $group->first()->loker->jabatan . ' - ' . 
                          $group->first()->loker->perusahaan->nama,
                'jumlah' => $group->count()
            ];
        })->values();       

        // Statistik tambahan
        $stats = [
            'total' => $lamaran->count(),
            'Diterima' => $lamaran->where('status', 'Diterima')->count(),
            'Ditolak' => $lamaran->where('status', 'Ditolak')->count(),
        ];

        return response()->json([
            'chartData' => $chartData,
            'stats' => $stats
        ]);
    }
}