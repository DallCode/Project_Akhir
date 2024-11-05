@extends('layout.main')

@section('content')
<div class="container">
    <h1>Laporan Alumni</h1>

    <!-- Form Laporan -->
    <form action="{{ route('laporan.preview') }}" method="GET">
        <!-- Jenjang Waktu -->
        <div class="form-group">
            <label for="jenjang_waktu">Pilih Jenjang Waktu:</label>
            <select name="jenjang_waktu" id="jenjang_waktu" class="form-control">
                <option value="1">1 Tahun Terakhir</option>
                <option value="3">3 Tahun Terakhir</option>
                <option value="5">5 Tahun Terakhir</option>
            </select>
        </div>

        <!-- Tahun Lulus -->
        <div class="form-group">
            <label for="tahun_lulus">Pilih Tahun Lulus:</label>
            <select name="tahun_lulus" id="tahun_lulus" class="form-control">
                @foreach($tahunLulusList as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
        </div>

        <!-- Detail Alumni yang Bekerja di Perusahaan Tertentu -->
        <div class="form-group">
            <label for="perusahaan">Perusahaan:</label>
            <select name="perusahaan" id="perusahaan" class="form-control">
                @foreach($perusahaanList as $perusahaan)
                    <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tracer Study Alumni -->
        <div class="form-group">
            <label for="tracer_study">Tracer Study:</label>
            <input type="checkbox" name="tracer_study" id="tracer_study" value="1">
        </div>

        <!-- Pilihan Format Ekspor -->
        <div class="form-group">
            <label for="export_format">Pilih Format Ekspor:</label>
            <select name="export_format" id="export_format" class="form-control">
                <option value="pdf">PDF</option>
                <option value="excel">Excel</option>
                <option value="csv">CSV</option>
            </select>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Preview</button>
        <button type="submit" formaction="{{ route('laporan.export') }}" class="btn btn-success">Export</button>
    </form>

    <!-- Preview Ekspor -->
    @if(isset($previewData))
        <div class="mt-5">
            <h2>Preview Laporan</h2>
            <!-- Data Preview Laporan -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Perusahaan</th>
                        <th>Jabatan</th>
                        <th>Tahun Lulus</th>
                        <th>Tracer Study</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($previewData as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->perusahaan->nama }}</td>
                            <td>{{ $data->jabatan }}</td>
                            <td>{{ $data->tahun_lulus }}</td>
                            <td>{{ $data->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
