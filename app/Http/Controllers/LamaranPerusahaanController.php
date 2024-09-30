<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Loker;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LamaranPerusahaanController extends Controller
{
    public function index()
    {

         // Mendapatkan data perusahaan yang sedang login berdasarkan username
         $perusahaanLogin = Perusahaan::where('username', Auth::user()->username)->first();

        //  // Cek jika perusahaan yang login ada
        //  if (!$perusahaanLogin) {
        //      return redirect()->back()->with('error', 'Perusahaan tidak ditemukan.');
        //  }
 
         // Memfilter data lamaran berdasarkan id_data_perusahaan dari perusahaan yang sedang login
         $lamaran = Lamaran::with(['alumni', 'loker'])
         ->whereHas('loker', function($query) use ($perusahaanLogin) {
             $query->where('id_data_perusahaan', $perusahaanLogin->id_data_perusahaan);
         })
         ->get();
 
         // Mengirimkan data perusahaan yang login dan lamaran yang difilter ke view
         return view('lamaranperusahaan', compact('perusahaanLogin', 'lamaran'));
    }
}
