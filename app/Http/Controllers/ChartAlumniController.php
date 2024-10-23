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
        // Mengambil data perusahaan berdasarkan username user yang sedang login
        $alumniLogin = Alumni::where('username', Auth::user()->username)->first();
        return view('chartalumni', compact('alumniLogin'));
    }

    public function getUserLamaranData()
{
    $user = auth()->user(); // Asumsi user sudah login
    $lamaran = Lamaran::with('loker')
        ->where('nik', $user->nik)
        ->get(); // Ambil semua lamaran tanpa filter status

    // Menghitung jumlah lamaran per lowongan
    $lamaranData = $lamaran->groupBy('id_lowongan_pekerjaan')->map(function ($group) {
        return [
            'loker' => $group->first()->loker->nama_lowongan,
            'jumlah' => $group->count() // Menghitung jumlah lamaran per lowongan
        ];
    });

    return response()->json($lamaranData->values());
}

    
}
