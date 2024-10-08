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
                    <h3>Data Alumni</h3>
                    <p class="text-subtitle text-muted">For user to check they list</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Simple Datatable
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Jurusan</th>
                                <th>Tahun Lulus</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumni as $all)
                                <tr>
                                    <td>{{ $all->nik }}</td>
                                    <td>{{ $all->nama }}</td>
                                    <td>{{ $all->jurusan }}</td>
                                    <td>{{ $all->tahun_lulus }}</td>
                                    <td>
                                        <button class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $all->nik }}">Detail</button>
                                        <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $all->nik }}">Edit</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @foreach ($alumni as $all)
                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $all->nik }}" tabindex="-1"
                            aria-labelledby="detailModalLabel{{ $all->nik }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel{{ $all->nik }}">Detail Alumni</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center mb-4">
                                                <img src="{{ $all->foto ? asset('storage/foto/' . $all->foto) : ($all->jenis_kelamin == 'Laki Laki' ? asset('bkk/dist/assets/images/faces/4.jpg') : asset('bkk/dist/assets/images/faces/3.jpg')) }}"
                                                    class="rounded-circle img-thumbnail" alt="Profile Image"
                                                    style="width: 200px; height: 200px; object-fit: cover;">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p><strong>NIK:</strong> {{ $all->nik }}</p>
                                                        <p><strong>Nama:</strong> {{ $all->nama }}</p>
                                                        <p><strong>Jurusan:</strong> {{ $all->jurusan }}</p>
                                                        <p><strong>Tahun Lulus:</strong> {{ $all->tahun_lulus }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <h6 class="border-bottom pb-2">Deskripsi</h6>
                                            <div class="card">
                                                <div class="card-body">
                                                    {{ $all->deskripsi ?? 'Tidak ada deskripsi' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $all->nik }}" tabindex="-1"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('alumni.update', $all->nik) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Alumni</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nik" class="form-label">NIK</label>
                                                <input type="text" class="form-control" name="nik"
                                                    value="{{ $all->nik }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control" name="nama"
                                                    value="{{ $all->nama }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jurusan" class="form-label">Jurusan</label>
                                                <select class="form-control" id="jurusan" name="jurusan">
                                                    <option value="AK" {{ $all->jurusan == 'AK' ? 'selected' : '' }}>
                                                        AK
                                                    </option>
                                                    <option value="BR" {{ $all->jurusan == 'BR' ? 'selected' : '' }}>
                                                        BR
                                                    </option>
                                                    <option value="DKV" {{ $all->jurusan == 'DKV' ? 'selected' : '' }}>
                                                        DKV
                                                    </option>
                                                    <option value="MLOG"
                                                        {{ $all->jurusan == 'MLOG' ? 'selected' : '' }}>
                                                        MLOG</option>
                                                    <option value="MP" {{ $all->jurusan == 'MP' ? 'selected' : '' }}>
                                                        MP
                                                    </option>
                                                    <option value="RPL" {{ $all->jurusan == 'RPL' ? 'selected' : '' }}>
                                                        RPL
                                                    </option>
                                                    <option value="TKJ" {{ $all->jurusan == 'TKJ' ? 'selected' : '' }}>
                                                        TKJ
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                                                <input type="number" class="form-control" name="tahun_lulus"
                                                    value="{{ $all->tahun_lulus }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                                <textarea class="form-control" name="deskripsi">{{ $all->deskripsi }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="avatar" class="form-label">Avatar</label>
                                                <input type="file" class="form-control" name="avatar">
                                                <small>Format: jpeg, png, jpg, gif. Max size: 2MB</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            @endforeach
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
    </script>

    <script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>
@endsection
