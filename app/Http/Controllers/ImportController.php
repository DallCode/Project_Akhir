<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use App\Imports\AlumniImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    public function index()
    {
        return view('importalumni');
    }

    public function uploadFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx|max:10240', // Maksimal 10MB
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->storeAs('uploads', $fileName, 'public');

                return response()->json(['fileName' => $fileName]);
            }

            return response()->json(['error' => 'Tidak ada file yang di Upload'], 400);
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return response()->json(['error' =>  $e->getMessage()], 500);
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required',
            ]);

            $fileName = $request->input('file');
            $filePath = storage_path('app/public/uploads/' . $fileName);

            if (!file_exists($filePath)) {
                throw new \Exception('File tidak ditemukan: ' . $filePath);
            }

            Excel::import(new AlumniImport, $filePath);

            // Menghapus file setelah diimpor
            Storage::delete('public/uploads/' . $fileName);

            return response()->json([
                'alert' => 'File berhasil diimpor.',
                'alert_type' => 'success'
            ]);
        } catch (ValidationException $e) {
            Log::error('Kesalahan validasi saat import: ' . json_encode($e->errors()));
            return response()->json([
                'alert' => 'Kesalahan Validasi: ' . json_encode($e->errors()),
                'alert_type' => 'danger'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat import file: ' . $e->getMessage());
            return response()->json([
                'alert' => 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage(),
                'alert_type' => 'danger'
            ], 500);
        }
    }
}
