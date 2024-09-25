<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loker;

class DetailLokerController extends Controller
{
    public function show($id)
    {
        // Ambil detail lowongan pekerjaan berdasarkan ID
        $loker = Loker::with('perusahaan')->findOrFail($id);

        // Kirim data loker ke view
        return view('detailloker', compact('loker'));
    }
}
