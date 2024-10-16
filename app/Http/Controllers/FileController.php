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
}
