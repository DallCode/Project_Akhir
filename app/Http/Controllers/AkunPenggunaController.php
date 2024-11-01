<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunpenggunaController extends Controller
{
    public function index()
    {
        $users = User::with('aktivitas')->get(); // Mengambil data pengguna beserta aktivitas
        return view('Akunpengguna', compact('users'));
    }

    public function updatePassword(Request $request, $username)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',  // Validasi confirm password
        ]);

        $user = User::where('username', $username)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('akunpengguna')->with('success', 'Password berhasil diperbarui.');
    }
}
