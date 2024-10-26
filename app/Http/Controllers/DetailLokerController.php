<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loker;
use App\Models\Perusahaan;

class DetailLokerController extends Controller
{
    public function show($id)
    {
        // Ambil detail lowongan pekerjaan berdasarkan ID dan perusahaan terkait
        $loker = Loker::with('perusahaan')->findOrFail($id);
        $perusahaan = $loker->perusahaan;

        // Kirim data loker dan perusahaan ke view
        return view('detailloker', compact('loker', 'perusahaan'));
    }
}
