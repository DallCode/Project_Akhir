<?php

namespace App\Http\Controllers;

use App\Imports\PerusahaanImport;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class TambahDataPerusahaanController extends Controller
{
    public function index()
    {
        return view('tambahdataperusahaan');
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'bidang_usaha' => 'required|string|max:255',
                'no_telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:255',
                'provinsi' => 'required|string|max:255',
                'kota' => 'required|string|max:255',
                'kecamatan' => 'required|string|max:255',
                'kelurahan' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:6',
                'logo' => 'required|string|max:2048',
            ]);

            // DB::beginTransaction();

            // Buat user baru
            $user = User::create([
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => 'Perusahaan',
            ]);

            // Upload logo
            $logoPath = '';
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $logoPath = 'images/' . $fileName;
            }

            // Buat data perusahaan
            $perusahaan = Perusahaan::create([
                'username' => $user->username,
                'nama' => $validated['nama'],
                'bidang_usaha' => $validated['bidang_usaha'],
                'no_telepon' => $validated['no_telepon'],
                'alamat' => $validated['alamat'],
                'provinsi' => $validated['provinsi'],
                'kota' => $validated['kota'],
                'kecamatan' => $validated['kecamatan'],
                'kelurahan' => $validated['kelurahan'],
                'logo' => $logoPath,
                'status' => 'Aktif' // Set default status
            ]);

            // DB::commit();

            return redirect('/dataperusahaan')
                ->with('success', 'Data perusahaan berhasil ditambahkan');

        } catch (\Exception $e) {
            // DB::rollback();

            // Hapus file yang sudah terupload jika ada error
            if (isset($logoPath) && Storage::exists('public/' . $logoPath)) {
                Storage::delete('public/' . $logoPath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data perusahaan: ' . $e->getMessage());
        }
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = uniqid(true) . '-' . $file->getClientOriginalName();
            $file->storeAs('images/', $fileName, 'public');

            return $fileName;
        }

        return '';
    }

    public function uploadFilePerusahaan(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx|max:10240', // Maksimal 10MB
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->storeAs('uploadsFile', $fileName, 'public');

                return response()->json(['fileName' => $fileName], 200); // Pastikan status 200 dikembalikan
            }

            return response()->json(['error' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function importperusahaan(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required',
            ]);

            $fileName = $request->input('file');
            $filePath = storage_path('app/public/uploadsFile/' . $fileName);

            if (!file_exists($filePath)) {
                throw new \Exception('File tidak ditemukan: ' . $filePath);
            }

            Excel::import(new PerusahaanImport, $filePath);

            // Menghapus file setelah diimpor
            Storage::delete('public/uploadsFile/' . $fileName);

            return response()->json([
                'alert' => 'File berhasil diimpor.',
                'alert_type' => 'success'
            ]);
        } catch (ValidationException $e) {
            Log::error('Kesalahan validasi selama impor: ' . json_encode($e->errors()));
            return response()->json([
                'alert' => 'Kesalahan validasi: ' . json_encode($e->errors()),
                'alert_type' => 'danger'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Kesalahan saat mengimpor: ' . $e->getMessage());
            return response()->json([
                'alert' => 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage(),
                'alert_type' => 'danger'
            ], 500);
        }
    }
}
