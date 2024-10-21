<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunpenggunaController extends Controller
{
    public function index()
    {
        $users = User::all(); // Mengambil semua data pengguna
        return view('Akunpengguna', compact('users')); // Mengirimkan data ke view
    }

    public function updatePassword(Request $request, $username)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',  // Validasi confirm password
        ]);

        $user = User::findOrFail($username);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('akunpengguna')->with('success', 'Password berhasil diperbarui.');
    }
}

