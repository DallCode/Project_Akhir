<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lamaran; // Model untuk lamaran
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LamaranSayaController extends Controller
{
    public function index()
    {
        // Ambil semua data lamaran
    $lamarans = Lamaran::all();

    // Loop setiap lamaran untuk menambahkan pesan alasan
    foreach ($lamarans as $lamaran) {
        $filename = $lamaran->id_lamaran . '_' . $lamaran->alumni->nama . '.txt'; // Nama file sesuai ID lamaran

        $lamaran->pesan = Storage::exists('public/pesan_lamaran/' . $filename)
                            ? Storage::get('public/pesan_lamaran/' . $filename)
                            : 'Tidak ada pesan.'; // Tambahkan pesan ke objek lamaran
    }
        return view('lamaransaya', compact('lamarans'));
    }
}
