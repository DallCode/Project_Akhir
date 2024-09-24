<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class DataperusahaanController extends Controller
{
    public function index()
    {
        // Menghitung semua data alumni
        $perusahaan = Perusahaan::All();
        return view('dataperusahaan', compact('perusahaan',));
    }

    public function update(Request $request, string $id_data_perusahaan)
    {

        $perusahaan = Perusahaan::find($id_data_perusahaan);


        // if ($request->input('status')) {
            $perusahaan->update(['status' => $request->input('status')]);
            // }
            $perusahaan->nama = $request->input('nama');
            $perusahaan->bidang_usaha = $request->input('bidang_usaha');
            $perusahaan->no_telepon = $request->input('no_telepon');
        $perusahaan->alamat = $request->input('alamat');
        $perusahaan->save();


        return redirect()->route('perusahaan.index')->with('success', 'Data perusahaan berhasil diperbarui.');

    }


}