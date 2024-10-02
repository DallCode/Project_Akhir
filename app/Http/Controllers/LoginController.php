<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use App\Models\pengguna;
use App\Models\User;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function show()
    {
        if (!Auth::user()) {
            return view('auth.login');
        }
        return redirect()->back();
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Mencari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak terdaftar pada aplikasi.');
        }

        // Memeriksa kecocokan password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Password yang Anda masukkan salah.');
        }

        // Jika user adalah perusahaan, cek status akun perusahaan
        if ($user->role == 'Perusahaan') {
            $perusahaan = Perusahaan::where('username', $user->username)->first();

            // Memastikan data perusahaan ditemukan
            if (!$perusahaan) {
                return redirect()->back()->with('error', 'Data perusahaan tidak ditemukan.');
            }

            // Memeriksa status akun perusahaan
            if ($perusahaan->status == 'Tidak Aktif') {
                return redirect()->back()->with('error', 'Akun perusahaan sudah Tidak Aktif.');
            }
        }

        // Login user
        Auth::login($user);
        $role = $user->role;

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->route('dashboard', compact('role'))->with('success', 'Login berhasil');
    }


    public function logout()
    {
        // return Auth::user();
        Auth::logout();
        return redirect()->route('login');
    }
}
