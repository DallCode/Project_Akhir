<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lamaran; // Model untuk lamaran
use Illuminate\Support\Facades\Auth;

class LamaranSayaController extends Controller
{
    public function index()
    {
        // Ambil data lamaran yang terkait dengan user yang sedang login
        $lamaranSaya = Lamaran::with(['loker'])
            ->where('nik', Auth::id()) // Sesuaikan dengan kolom yang menyimpan ID user
            ->get();

        // Kirim data lamaran ke view

        return view('lamaranSaya', compact('lamaranSaya'));
    }
}