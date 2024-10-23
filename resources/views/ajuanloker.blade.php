@extends('layout.main')

@section('content')
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

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
                    <h3>Ajuan Loker</h3>
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
                            <label>Nama Perusahaan</label>
                            <select class="form-select" id="perusahaanFilter">
                                <option value="">Semua Perusahaan</option>
                                @php
                                    $perusahaans = $loker->pluck('nama')->unique();
                                @endphp
                                @foreach ($perusahaans as $perusahaan)
                                    <option value="{{ $perusahaan }}">{{ $perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Posisi</label>
                            <select class="form-select" id="posisiFilter">
                                <option value="">Semua Posisi</option>
                                @php
                                    $posisi = $loker->pluck('jabatan')->unique();
                                @endphp
                                @foreach ($posisi as $p)
                                    <option value="{{ $p }}">{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Status Publikasi</label>
                            <select class="form-select" id="statuspublikasiFilter">
                                <option value="">Semua Status Publikasi</option>
                                @php
                                    $status = $loker->pluck('status')->unique()->sort();
                                @endphp
                                @foreach ($status as $stat)
                                    <option value="{{ $stat }}">{{ $stat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    Simple Datatable
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Jabatan</th>
                                <th>status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loker as $lowongan)
                                <tr data-status="{{ $lowongan->status }}">
                                    <td>{{ $lowongan->perusahaan->nama }}</td>
                                    <td>{{ $lowongan->jabatan }}</td>
                                    <td>{{ $lowongan->status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $lowongan->id_lowongan_pekerjaan }}">
                                            Lihat Detail
                                        </button>

                                        <!-- The Modal -->
                                        <div class="modal fade" id="detailModal{{ $lowongan->id_lowongan_pekerjaan }}"
                                            tabindex="-1" data-bs-backdrop="false"
                                            aria-labelledby="detailModalLabel{{ $lowongan->id_lowongan_pekerjaan }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="detailModalLabel{{ $lowongan->id_lowongan_pekerjaan }}">
                                                            Detail Lowongan : {{ $lowongan->jabatan }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Perusahaan:</strong>
                                                            {{ $lowongan->perusahaan->nama }}</p>
                                                        <p><strong>Jenis Waktu Pekerjaan:</strong>
                                                            {{ $lowongan->jenis_waktu_pekerjaan }}</p>
                                                        <p><strong>Deskripsi:</strong>
                                                            {{ $lowongan->deskripsi }}</p>
                                                        <p><strong>Tanggal Akhir:</strong>
                                                            {{ $lowongan->tanggal_akhir }}</p>
                                                        <p><strong>Status:</strong> {{ $lowongan->status }}</p>

                                                        <!-- Dropdown to change status -->
                                                        <form
                                                            action="{{ route('update.status', $lowongan->id_lowongan_pekerjaan) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="status{{ $lowongan->id_lowongan_pekerjaan }}"
                                                                    class="form-label"><strong>Ubah
                                                                        Status:</strong></label>
                                                                <select class="form-select"
                                                                    id="status{{ $lowongan->id_lowongan_pekerjaan }}"
                                                                    name="status" onchange="toggleTextarea(this)">
                                                                    <option value="Dipublikasi"
                                                                        {{ $lowongan->status == 'Dipublikasi' ? 'selected' : '' }}>
                                                                        Dipublikasi</option>
                                                                    <option value="Tidak Dipublikasi"
                                                                        {{ $lowongan->status == 'Tidak Dipublikasi' ? 'selected' : '' }}>
                                                                        Tidak Dipublikasi</option>
                                                                </select>
                                                            </div>

                                                            <!-- Textarea for alasan -->
                                                            <div class="mb-3"
                                                                id="alasanContainer{{ $lowongan->id_lowongan_pekerjaan }}"
                                                                style="display: none;">
                                                                <label for="alasan{{ $lowongan->id_lowongan_pekerjaan }}"
                                                                    class="form-label"><strong>Alasan Tidak
                                                                        Dipublikasi:</strong></label>
                                                                <textarea class="form-control" id="alasan{{ $lowongan->id_lowongan_pekerjaan }}" name="alasan" rows="3"></textarea>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Simpan
                                                                    Perubahan</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
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
                gravity: "top", // 'top' or 'bottom'
                position: 'right', // 'left', 'center' or 'right'
                backgroundColor: "{{ session('success') ? '#4CAF50' : '#F44336' }}", // Hijau untuk success, Merah untuk error
                stopOnFocus: true, // Prevents dismissing of toast on hover
            }).showToast();
        @endif
    </script>


    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);

        function toggleTextarea(selectElement) {
            var alasanContainer = document.getElementById('alasanContainer{{ $lowongan->id_lowongan_pekerjaan }}');
            if (selectElement.value === 'Tidak Dipublikasi') {
                alasanContainer.style.display = 'block';
            } else {
                alasanContainer.style.display = 'none';
            }
        }

        // Initialize textarea visibility based on current status
        document.addEventListener('DOMContentLoaded', function() {
            var statusSelect = document.getElementById('status{{ $lowongan->id_lowongan_pekerjaan }}');
            toggleTextarea(statusSelect);
        });

        document.getElementById('perusahaanFilter').addEventListener('change', filterData);
        document.getElementById('posisiFilter').addEventListener('change', filterData);
        document.getElementById('statusFilter').addEventListener('change', filterData);

        function filterData() {
            const perusahaan = document.getElementById('perusahaanFilter').value;
            const posisi = document.getElementById('posisi').value;
            const status = document.getElementById('status').value;

            let searchQuery = [];

            if (perusahaan) searchQuery.push(perusahaan);
            if (posisi) searchQuery.push(posisi);
            if (status) searchQuery.push(status);

            // Filter based on the values
            if (searchQuery.length > 0) {
                dataTable.search(searchQuery.join(' ')).draw();
            } else {
                dataTable.search('').draw(); // Clear the search if no filters are applied
            }
        }
    </script>

    <script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>
@endsection
