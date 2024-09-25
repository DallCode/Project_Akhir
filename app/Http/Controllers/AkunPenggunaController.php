<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\User;
use App\Models\Aktivitas;
use Illuminate\Http\Request;

class AkunpenggunaController extends Controller
{
    public function index()
    {
        $users = User::all(); // Mengambil semua data pengguna
        $aktivitas = User::all();
        return view('Akunpengguna', compact('users', 'aktivitas')); // Mengirimkan data ke view
    }
}
