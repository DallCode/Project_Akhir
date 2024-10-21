<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilePerusahaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        $perusahaan = $user->perusahaan;

        if (!$perusahaan) {
            return redirect()->back()->with('error', 'Perusahaan profile not found.');
        }

        return view('profileperusahaan', compact('user', 'perusahaan'));
    }

    public function update(Request $request, $id_data_perusahaan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $perusahaan = Perusahaan::findOrFail($id_data_perusahaan);
        $perusahaan->update($request->only(['nama', 'bidang_usaha', 'alamat', 'no_telepon', 'status']));

        return redirect()->route('profileperusahaan')->with('success', 'Profile berhasil diperbaharui');
    }

    public function perusahaanupdatePhoto(Request $request, $id_data_perusahaan)
    {
        $perusahaan = Perusahaan::findOrFail($id_data_perusahaan);

        // Validasi input
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Hapus foto lama jika ada
        if ($perusahaan->logo && Storage::exists('public/images/' . $perusahaan->logo)) {
            Storage::delete('public/images/' . $perusahaan->logo);
        }

        // Simpan foto baru
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/images', $filename);

            // Update kolom foto di database
            $perusahaan->logo = $filename;
            $perusahaan->save();

            session()->flash('success', 'Logo berhasil diperbarui.');
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

}
