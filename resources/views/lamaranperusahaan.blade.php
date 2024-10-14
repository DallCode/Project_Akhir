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
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lamaran as $lamar)
                    <tr>
                        <td>{{ $lamar->alumni->nama }}</td>
                        <td>{{ $lamar->loker->jabatan }}</td>
                        <td>{{ $lamar->status }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $lamar->id_lamaran }}">
                                Detail
                            </button>
                            @if($lamar->status == 'Terkirim')
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalLolos{{ $lamar->id_lamaran }}">
                                    Lolos Ke Tahap Selanjutnya
                                </button>
                            @elseif($lamar->status == 'Lolos Ketahap Selanjutnya')
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTerima{{ $lamar->id_lamaran }}">
                                    Terima
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolak{{ $lamar->id_lamaran }}">
                                    Tolak
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @foreach ($lamaran as $lamar)
            <!-- Modal Detail -->
            <div class="modal fade" id="modalDetail{{ $lamar->id_lamaran }}" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalDetailLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDetailLabel">Detail Pelamar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
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

            <!-- Modal Lolos Ke Tahap Selanjutnya -->
            <div class="modal fade" id="modalLolos{{ $lamar->id_lamaran }}" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalLolosLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLolosLabel">Lolos Ke Tahap Selanjutnya</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('updatestatus', $lamar->id_lamaran) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="hidden" name="status" value="Lolos Ketahap Selanjutnya">
                                <div class="form-group">
                                    <label for="alasan">Alasan Perubahan Status</label>
                                    <textarea name="alasan" id="alasan" rows="4" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Konfirmasi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Terima -->
            <div class="modal fade" id="modalTerima{{ $lamar->id_lamaran }}" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalTerimaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTerimaLabel">Terima Lamaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('updatestatus', $lamar->id_lamaran) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="hidden" name="status" value="Diterima">
                                <div class="form-group">
                                    <label for="alasan">Alasan Penerimaan</label>
                                    <textarea name="alasan" id="alasan" rows="4" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Konfirmasi Terima</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Tolak -->
            <div class="modal fade" id="modalTolak{{ $lamar->id_lamaran }}" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalTolakLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTolakLabel">Tolak Lamaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('updatestatus', $lamar->id_lamaran) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="hidden" name="status" value="Ditolak">
                                <div class="form-group">
                                    <label for="alasan">Alasan Penolakan</label>
                                    <textarea name="alasan" id="alasan" rows="4" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Konfirmasi Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
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
