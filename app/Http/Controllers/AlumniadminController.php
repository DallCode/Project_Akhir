<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;

class AlumniadminController extends Controller
{

    public function index()
    {
        $alumni = Alumni::all();
        return view('Alumniadmin', compact('alumni'));
    }

     // Fungsi update untuk mengupdate data alumni
     public function update(Request $request, string $nik)
     {
         $alumni = Alumni::findOrFail($nik);

        //  // Validasi data jika diperlukan
        //  $validatedData = $request->validate([
        //     //  'nik' => 'required|string|max:255',
        //      'nama' => 'required|string|max:255',
        //      'jurusan' => 'required|string|max:255',
        //      'tahun_lulus' => 'required|integer',
        //      'deskripsi' => 'nullable|text',
        //      'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        //  ]);

         // Update data alumni
         $alumni->nik = $request->nik;
         $alumni->nama = $request->nama;
         $alumni->jurusan = $request->jurusan;
         $alumni->tahun_lulus = $request->tahun_lulus;
         $alumni->deskripsi = $request->deskripsi;

         $alumni->save();
        //  $alumni->additional_info = $request->additional_info;

         // Jika ada file avatar yang diupload, update avatar
         if ($request->hasFile('avatar')) {
             $file = $request->file('avatar');
             $filename = time() . '.' . $file->getClientOriginalExtension();
             $file->move(public_path('avatars'), $filename);
             $alumni->avatar_url = '/avatars/' . $filename;
         }



         // Redirect ke halaman sebelumnya atau halaman yang diinginkan
         return redirect()->back()->with('success', 'Data alumni berhasil diupdate');
     }





}
