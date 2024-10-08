@extends('layout.main')

@section('content')

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<!-- Stylesheets -->
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
                <h3>Lamaran Masuk</h3>
                <p class="text-subtitle text-muted">For users to check their list</p>
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
                        <th>Nama Pelamar</th>
                        <th>Posisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lamaran as $lamar)
                    <tr>
                        <td>{{ $lamar->alumni->nama }}</td>
                        <td>{{ $lamar->loker->jabatan }}</td>
                        <td>
                            <!-- Tombol Detail -->
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $lamar->id_lamaran }}">Detail</button>

                            <!-- Tombol Lolos ke Tahap Selanjutnya -->
                            @if($lamar->status == 'Terkirim')
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalLolos{{ $lamar->id_lamaran }}">Lolos ke Tahap Selanjutnya</button>
                            @else
                                <button class="btn btn-primary" disabled>Lolos ke Tahap Selanjutnya</button>
                            @endif

                            <!-- Tombol Diterima dan Ditolak -->
                            @if($lamar->status == 'Lolos Ketahap Selanjutnya')
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalDiterima{{ $lamar->id_lamaran }}">Diterima</button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDitolak{{ $lamar->id_lamaran }}">Ditolak</button>
                            @elseif($lamar->status == 'diterima')
                                <button class="btn btn-success" disabled>Diterima</button>
                                <button class="btn btn-danger" disabled>Ditolak</button>
                            @elseif($lamar->status == 'ditolak')
                                <button class="btn btn-success" disabled>Diterima</button>
                                <button class="btn btn-danger" disabled>Ditolak</button>
                            @else
                                <button class="btn btn-success" disabled>Diterima</button>
                                <button class="btn btn-danger" disabled>Ditolak</button>
                            @endif
                        </td>

                    </tr>

                    @endforeach
                </tbody>
            </table>

            <!-- Modal Detail -->
            <div class="modal fade" id="modalDetail{{ $lamar->id_lamaran }}" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalDetailLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDetailLabel">Detail Pelamar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Tampilkan detail pelamar -->
                            <p>Nama: {{ $lamar->alumni->nama }}</p>
                            <p>Posisi: {{ $lamar->loker->jabatan }}</p>
                            <p>Deskripsi: {{ $lamar->alumni->deskripsi }}</p>
                            <!-- Tambahkan informasi lain sesuai kebutuhan -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal untuk Lolos ke Tahap Selanjutnya -->
            <div class="modal fade" id="modalLolos{{ $lamar->id_lamaran }}" tabindex="-1" aria-labelledby="modalLolosLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('lamaran.lolos', $lamar->id_lamaran) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLolosLabel">Lolos ke Tahap Selanjutnya</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <textarea name="pesan" class="form-control" placeholder="Pesan untuk pelamar"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal untuk Diterima -->
            <div class="modal fade" id="modalDiterima{{ $lamar->id_lamaran }}" tabindex="-1" aria-labelledby="modalDiterimaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('lamaran.diterima', $lamar->id_lamaran) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDiterimaLabel">Diterima</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <textarea name="pesan" class="form-control" placeholder="Pesan untuk pelamar"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-success">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal untuk Ditolak -->
            <div class="modal fade" id="modalDitolak{{ $lamar->id_lamaran }}" tabindex="-1" aria-labelledby="modalDitolakLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('lamaran.ditolak', $lamar->id_lamaran) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDitolakLabel">Ditolak</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <textarea name="pesan" class="form-control" placeholder="Pesan untuk pelamar"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-danger">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
</script>

<script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>
@endsection
