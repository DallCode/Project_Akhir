<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\Perusahaan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AlumniExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $tahunLulusList = Alumni::select('tahun_lulus')->distinct()->pluck('tahun_lulus');
        $perusahaanList = Perusahaan::all();

        return view('laporan', compact('tahunLulusList', 'perusahaanList'));
    }

    public function preview(Request $request)
    {
        $previewData = Alumni::with('perusahaan')
            ->when($request->jenjang_waktu, function($query, $jenjang) {
                return $query->where('tahun_lulus', '>=', now()->year - $jenjang);
            })
            ->when($request->tahun_lulus, function($query, $tahun) {
                return $query->where('tahun_lulus', $tahun);
            })
            ->when($request->perusahaan, function($query, $perusahaan) {
                return $query->whereHas('perusahaan', function($q) use ($perusahaan) {
                    $q->where('id', $perusahaan);
                });
            })
            ->when($request->tracer_study, function($query) {
                return $query->where('tracer_study', true);
            })
            ->get();

        return view('laporan', [
            'previewData' => $previewData,
            'tahunLulusList' => Alumni::select('tahun_lulus')->distinct()->pluck('tahun_lulus'),
            'perusahaanList' => Perusahaan::all()
        ]);
    }

    public function export(Request $request)
    {
        $format = $request->input('export_format', 'pdf');

        $data = Alumni::with('perusahaan')
            ->when($request->jenjang_waktu, function($query, $jenjang) {
                return $query->where('tahun_lulus', '>=', now()->year - $jenjang);
            })
            ->when($request->tahun_lulus, function($query, $tahun) {
                return $query->where('tahun_lulus', $tahun);
            })
            ->when($request->perusahaan, function($query, $perusahaan) {
                return $query->whereHas('perusahaan', function($q) use ($perusahaan) {
                    $q->where('id', $perusahaan);
                });
            })
            ->when($request->tracer_study, function($query) {
                return $query->where('tracer_study', true);
            })
            ->get();

        if ($format == 'pdf') {
            $pdf = Pdf::loadView('exports.alumni_pdf', compact('data'));
            return $pdf->download('laporan_alumni.pdf');
        } elseif ($format == 'excel') {
            return Excel::download(new AlumniExport($data), 'laporan_alumni.xlsx');
        } elseif ($format == 'csv') {
            return Excel::download(new AlumniExport($data), 'laporan_alumni.csv');
        } else {
            return redirect()->back()->with('error', 'Format ekspor tidak valid');
        }
    }
}
