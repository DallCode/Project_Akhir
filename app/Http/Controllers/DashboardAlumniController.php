<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\FileLamaran;
use App\Models\Lamaran;
use App\Models\Loker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardalumniController extends Controller
{
    public function index(Request $request)
    {
        $alumniLogin = Alumni::where('username', Auth::user()->username)->first();

        $query = request()->query('search');

        $Loker = Loker::where('status', 'Dipublikasi')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($q) use ($query) {
                    $q->where('jabatan', 'like', "%{$query}%")
                        ->orWhereHas('perusahaan', function ($q) use ($query) {
                            $q->where('nama', 'like', "%{$query}%");
                        });
                });
            })
            ->with('perusahaan')
            ->paginate(10);

        return view('dashboardAlumni', compact('alumniLogin', 'Loker'));
    }

    public function store(Request $request)
    {
        $alumniLogin = Alumni::where('username', Auth::user()->username)
            ->with(['pendidikanformal', 'pendidikannonformal', 'kerja',])
            ->first();

        // Cek kelengkapan profil
        $incompleteFields = $this->checkProfileCompleteness($alumniLogin);
        if (!empty($incompleteFields)) {
            session(['incomplete_profile' => $incompleteFields]);
            return redirect()->back()->with('error', 'Please complete your profile before applying.');
        }

        // Ambil lowongan pekerjaan
        $loker = Loker::find($request->id_lowongan_pekerjaan);
        if (!$loker) {
            return redirect()->back()->with('error', 'Belum ada lamaran yang diposting');
        }

        // Cek apakah lamaran sudah pernah dikirim untuk lowongan ini oleh alumni
        $existingLamaran = Lamaran::where('id_lowongan_pekerjaan', $request->id_lowongan_pekerjaan)
            ->where('nik', $alumniLogin->nik)
            ->first();

        if ($existingLamaran) {
            return redirect()->back()->with('error', 'Anda sudah melamar pekerjaan ini.');
        }

        // Membuat dan menyimpan data lamaran baru
        $lamaran = Lamaran::create([
            'id_lamaran' => Lamaran::generateKodeUnik(),
            'id_lowongan_pekerjaan' => $request->id_lowongan_pekerjaan,
            'nik' => $alumniLogin->nik,
            'status' => 'terkirim',
            'waktu' => Carbon::now(),
        ]);

        // Proses penyimpanan file jika ada
        if ($request->has('file') && is_array($request->file)) {
            foreach ($request->file as $fileJson) {
                $fileData = json_decode($fileJson, true);
                if ($fileData && isset($fileData['fileName'])) {
                    FileLamaran::create([
                        'id_lamaran' => $lamaran->id_lamaran,
                        'nama_file' => $fileData['fileName'],
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Lamaran Berhasil Dikirim');
    }



    private function checkProfileCompleteness($alumni)
    {
        $incompleteFields = [];
        $requiredFields = ['nama', 'jenis_kelamin', 'lokasi', 'alamat', 'kontak', 'keahlian', 'deskripsi'];

        foreach ($requiredFields as $field) {
            if (empty($alumni->$field)) {
                $incompleteFields[] = $field;
            }
        }

        if ($alumni->pendidikanformal->isEmpty()) {
            $incompleteFields[] = 'pendidikan_formal';
        }

        return $incompleteFields;
    }

    public function uploadTemp(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|max:10240', // Maksimal 10MB
            ]);

            if ($request->hasFile('file')) {
                foreach ($request->file as $file) {
                    $fileName = time() . '-' . $file->getClientOriginalName();
                    $file->storeAs('lamaran', $fileName, 'public');

                    return response()->json(['fileName' => $fileName]);
                }
            }

            return response()->json(['error' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return response()->json(['error' =>  $e->getMessage()], 500);
        }
    }
    // // Memastikan bahwa ada file yang diunggah
    // if ($request->hasFile('file')) {
    //     // Menyimpan semua file yang diunggah
    //     $files = $request->file('file');
    //     $filenames = [];

    //     foreach ($files as $file) {
    //         // Membuat nama file unik
    //         $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    //         $file->storeAs('public/lamaran', $filename);
    //         $filenames[] = $filename;  // Menyimpan nama file dalam array
    //     }

    //     // Mengembalikan respons JSON dengan nama file
    //     return response()->json(['filenames' => $filenames]);
    // }

    // // Mengembalikan respons error jika tidak ada file yang diunggah
    // return response()->json(['error' => 'No file uploaded'], 400);
}
