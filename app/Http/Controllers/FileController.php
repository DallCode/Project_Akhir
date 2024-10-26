<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function downloadTemplate()
    {
        $filePath = public_path('filetemplate/data_siswa.xlsx');
        return response()->download($filePath, 'data_siswa.xlsx');
    }

    public function Template()
    {
        $filePath = public_path('filetemplate/Format.xlsx');
        return response()->download($filePath, 'Format.xlsx');
    }

    public function downloadFormat()
    {
        $filePath = public_path('fileformat/data_perusahaan.xlsx');
        return response()->download($filePath, 'data_perusahaan.xlsx');
    }

    public function Format()
    {
        $filePath = public_path('fileformat/Format.xlsx');
        return response()->download($filePath, 'Format.xlsx');
    }
}
