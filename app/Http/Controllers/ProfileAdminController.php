<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        $admin = $user->admin;

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin profile not found.');
        }

        return view('profileadmin', compact('user', 'admin'));
    }

    public function update(Request $request, $nip)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki Laki,Perempuan',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $admin = Admin::findOrFail($nip);
        $admin->update($request->only(['nama_lengkap', 'jenis_kelamin', 'alamat', 'kontak', 'status']));

        return redirect()->route('profileadmin')->with('success', 'Profile berjasil diperbaharui');
    }

    public function adminupdatePhoto(Request $request, $nip)
    {
        $admin = Admin::findOrFail($nip);

        // Validasi input
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Hapus foto lama jika ada
        if ($admin->foto && Storage::exists('public/foto-admin/' . $admin->foto)) {
            Storage::delete('public/foto-admin/' . $admin->foto);
        }

        // Simpan foto baru
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/foto-admin', $filename);

            // Update kolom foto di database
            $admin->foto = $filename;
            $admin->save();

            session()->flash('success', 'Foto berhasil diperbarui.');
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}
