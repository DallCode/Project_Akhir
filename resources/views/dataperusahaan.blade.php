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
                <h3>Data Perusahaan</h3>
                <p class="text-subtitle text-muted">For user to check their list</p>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Simple Datatable
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h5>Filter Data</h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Bidang Usaha</label>
                        <select class="form-select" id="bidangusahaFilter">
                            <option value="">Semua Bidang Usaha</option>
                            @php
                                $bidangusaha = $perusahaan->pluck('bidang_usaha')->unique();
                            @endphp
                            @foreach ($bidangusaha as $bu)
                                <option value="{{ $bu }}">{{ $bu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>No Telepon</label>
                        <select class="form-select" id="noteleponFilter">
                            <option value="">Semua No Telepon</option>
                            @php
                                $notelepon = $perusahaan->pluck('no_telepon')->unique();
                            @endphp
                            @foreach ($notelepon as $nt)
                                <option value="{{ $nt }}">{{ $nt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            @php
                                $status = $perusahaan->pluck('status')->unique()->sort();
                            @endphp
                            @foreach ($status as $stat)
                                <option value="{{ $stat }}">{{ $stat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama Perusahaan</th>
                            <th>Bidang Usaha</th>
                            <th>Nomer Telepon</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perusahaan as $p)
                        <tr>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->bidang_usaha }}</td>
                            <td>{{ $p->no_telepon }}</td>
                            <td>{{ $p->alamat }}</td>
                            <td>{{ $p->status }}</td>
                            <td>
                                <!-- Button trigger modal edit -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal-{{ $p->id_data_perusahaan }}">
                                    Edit
                                </button>

                                <!-- Modal for edit -->
                                <div class="modal fade" id="editModal-{{ $p->id_data_perusahaan }}" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editModalLabel-{{ $p->id_data_perusahaan }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel-{{ $p->id_data_perusahaan }}">Edit Perusahaan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form for edit -->
                                                <form action="{{ route('perusahaan.update', $p->id_data_perusahaan) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="nama-{{ $p->id_data_perusahaan }}" class="form-label">Nama Perusahaan</label>
                                                        <input type="text" class="form-control" id="nama-{{ $p->id_data_perusahaan }}" name="nama" value="{{ $p->nama }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="bidang_usaha-{{ $p->id_data_perusahaan }}" class="form-label">Bidang Usaha</label>
                                                        <input type="text" class="form-control" id="bidang_usaha-{{ $p->id_data_perusahaan }}" name="bidang_usaha" value="{{ $p->bidang_usaha }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="no_telepon-{{ $p->id_data_perusahaan }}" class="form-label">No Telepon</label>
                                                        <input type="text" class="form-control" id="no_telepon-{{ $p->id_data_perusahaan }}" name="no_telepon" value="{{ $p->no_telepon }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alamat-{{ $p->id_data_perusahaan }}" class="form-label">Alamat</label>
                                                        <textarea class="form-control" id="alamat-{{ $p->id_data_perusahaan }}" name="alamat" rows="3" required>{{ $p->alamat }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="status-{{ $p->id_data_perusahaan }}" class="form-label">Status</label>
                                                        <select class="form-select" id="status-{{ $p->id_data_perusahaan }}" name="status" required>
                                                            <option value="aktif" {{ $p->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                            <option value="tidak aktif" {{ $p->status === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
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

    document.getElementById('bidangusahaFilter').addEventListener('change', filterData);
        document.getElementById('noteleponFilter').addEventListener('change', filterData);
        document.getElementById('statusFilter').addEventListener('change', filterData);

        function filterData() {
            const bidangUsaha = document.getElementById('bidangusahaFilter').value;
            const noTelepon = document.getElementById('noteleponFilter').value;
            const status = document.getElementById('statusFilter').value;

            let searchQuery = [];

            if (bidangUsaha) searchQuery.push(bidangUsaha);
            if (noTelepon) searchQuery.push(noTelepon);
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
