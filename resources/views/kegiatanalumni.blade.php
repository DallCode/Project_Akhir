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
                    <h3>Lacak Alumni</h3>
                    <p class="text-subtitle text-muted">For user to check they list</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h5>Filter Data</h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Jurusan</label>
                            <select class="form-select" id="jurusanFilter">
                                <option value="">Semua Jurusan</option>
                                @php
                                    $jurusans = $kegiatan->pluck('jurusan')->unique();
                                @endphp
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan }}">{{ $jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tahun Lulus</label>
                            <select class="form-select" id="tahunFilter">
                                <option value="">Semua Tahun</option>
                                @php
                                    $tahuns = $kegiatan->pluck('tahun_lulus')->unique()->sort();
                                @endphp
                                @foreach($tahuns as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">Semua Status</option>
                                @php
                                    $statuses = $kegiatan->pluck('status')->unique();
                                @endphp
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Alumni</th>
                                <th>Jurusan</th>
                                <th>Tahun Lulus</th>
                                <th>Status</th>
                                <th>Pesan</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($kegiatan as $item)
                                <tr>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jurusan }}</td>
                                    <td>{{ $item->tahun_lulus }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pesanModal{{ $item->nik }}">
                                            <i class="fa fa-envelope"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="pesanModal{{ $item->nik }}" tabindex="-1" aria-labelledby="pesanModalLabel{{ $item->nik }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="pesanModalLabel{{ $item->nik }}">Pesan dari {{ $item->nama }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @php
                                                            $filePath = "public/alasan/alasan_" . $item->nik . ".txt";                                                            // Path file pesan di storage
                                                            if (Storage::exists($filePath)) {
                                                                $pesan = Storage::get($filePath);
                                                            } else {
                                                                $pesan = "Tidak ada pesan.";
                                                            }
                                                        @endphp
                                                        <p>{{ $pesan }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

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

        // Initialize DataTable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);

        // Add filter functionality
        document.getElementById('jurusanFilter').addEventListener('change', filterData);
        document.getElementById('tahunFilter').addEventListener('change', filterData);
        document.getElementById('statusFilter').addEventListener('change', filterData);

        function filterData() {
            const jurusan = document.getElementById('jurusanFilter').value;
            const tahun = document.getElementById('tahunFilter').value;
            const status = document.getElementById('statusFilter').value;

            dataTable.search('');
            let searchQuery = [];

            if (jurusan) searchQuery.push(jurusan);
            if (tahun) searchQuery.push(tahun);
            if (status) searchQuery.push(status);

            if (searchQuery.length > 0) {
                dataTable.search(searchQuery.join(' '));
            }
        }
    </script>

    <script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>
@endsection
