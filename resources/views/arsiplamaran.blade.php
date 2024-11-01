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
                    <h3>Arsip Lamaran</h3>
                    <p class="text-subtitle text-muted">For user to check they list</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5>Filter Data</h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <select class="form-select" id="jabatanFilter">
                                <option value="">Jabatan
                                @php
                                    $jabat = $arsip->pluck('jabatan')->unique();
                                @endphp
                                @foreach($jabat as $j)
                                    <option value="{{ $j }}">{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <select class="form-select" id="jenisFilter">
                                <option value="">Jenis Pekerjaan</option>
                                @php
                                    $jenis = $arsip->pluck('Jenis_waktu_pekerjaan')->unique();
                                @endphp
                                @foreach($jenis as $jwp )
                                    <option value="{{ $jwp }}">{{ $jwp }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">Status</option>
                                @php
                                    $statuses = $arsip->pluck('status')->unique();
                                @endphp
                                @foreach($statuses as $status )
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama Pelamar</th>
                                <th>Posisi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($arsip as $a)
                                <tr>
                                    <td>{{ $a->alumni->nama }}</td>
                                    <td>{{ $a->loker->jabatan }}</td>
                                    <td>{{ $a->status }}</td>
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
