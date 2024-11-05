@extends('layout.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('bkk/dist/assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Lamaran</h3>
                    <p class="text-subtitle text-muted">For user to check they list</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Simple Datatable
                </div>
                <div class="row">
                    <div class="col-12">
                        <h5>Filter Data</h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Nama Perusahaan</label>
                        <select class="form-select" id="namaFilter">
                            <option value="">Semua Perusahaan</option>
                            @php
                                $perusahaans = $lamarans->loker->perusahaan->pluck('nama')->unique();
                            @endphp
                            @foreach($perusahaans as $nama)
                                <option value="{{ $nama }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Posisi</label>
                        <select class="form-select" id="posisiFilter">
                            <option value="">Semua Posisi</option>
                            @php
                                $jabatan = $lamarans->loker->pluck('jabatan')->unique()->sort();
                            @endphp
                            @foreach($jabatan as $p)
                                <option value="{{ $p }}">{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            @php
                                $statuses = $lamarans->pluck('status')->unique();
                            @endphp
                            @foreach($statuses as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Posisi</th>
                                <th>Status</th>
                                <th>Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lamarans as $lamaran)
                                <tr>
                                    <td>{{ $lamaran->loker->perusahaan->nama }}</td>
                                    <td>{{ $lamaran->loker->jabatan }}</td>
                                    <td>{{ $lamaran->status }}</td>
                                    <td>{{ $lamaran->pesan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>


    <script src="{{ asset('bkk/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('bkk/dist/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('bkk/dist/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        @if (session('success') || session('error'))
            Toastify({
                text: "{{ session('success') ? session('success') : session('error') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: 'right',
                backgroundColor: "{{ session('success') ? '#4CAF50' : '#F44336' }}",
                stopOnFocus: true,
            }).showToast();
        @endif
    </script>

    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

    <script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>
@endsection
