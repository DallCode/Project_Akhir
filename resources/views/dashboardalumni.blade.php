@extends('layout.main')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<div class="container mt-4">
    <h2>Informasi Lowongan Pekerjaan</h2>

    <!-- Search Form -->
    <form method="GET" action="{{ route('job.search') }}" class="mb-5">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari lowongan..." value="{{ request()->query('search') }}">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <div class="row">
        @forelse($Loker as $item)
            <div class="col-md-6 mb-4">
                <div class="card hover-card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->jabatan }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $item->perusahaan->nama }}</h6>
                        <p class="card-text">
                            <i class="fas fa-clock"></i> {{ $item->jenis_waktu_pekerjaan }}<br>
                            <i class="fas fa-map-marker-alt"></i> {{ $item->perusahaan->alamat }}<br>
                            <i class="fas fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($item->waktu)->format('j M Y H:i') }} sampai
                            {{ $item->tanggal_akhir }}<br>
                        </p>
                        <p class="card-text">{{ $item->deskripsi }}</p>
                        <a href="{{ route('detailloker', $item->id_lowongan_pekerjaan) }}" class="btn btn-primary">Lihat Detail</a>

                        <button class="btn btn-outline-primary ml-2" data-bs-toggle="modal" data-bs-target="#lamarModal{{ $item->id_lowongan_pekerjaan }}">Lamar</button>
                    </div>
                </div>
            </div>

            <!-- Lamar Modal -->
            <div class="modal fade" id="lamarModal{{ $item->id_lowongan_pekerjaan }}" tabindex="-1" aria-labelledby="lamarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="lamarModalLabel">File Tambahan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Jika Anda tidak menambahkan file tambahan, maka kami akan mengambil informasi dari profil Anda.</p>
                            <div id="alert-container"></div>
                            <form action="{{ route('lamar.store') }}" method="POST" id="importForm" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" id="file_{{ $item->id_lowongan_pekerjaan }}" multiple class="filepond" />
                                <button type="submit" class="btn btn-primary mt-3">Upload and Import</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <strong>Belum ada lowongan</strong>
                </div>
            </div>
        @endforelse

        <div class="d-flex justify-content-center">
            {{ $Loker->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    @if (session('success'))
        Toastify({
            text: "{{ session('success') }}",
            duration: 3000,
            close: true,
            gravity: "top", // 'top' or 'bottom'
            position: 'right', // 'left', 'center' or 'right'
            backgroundColor: "#4CAF50",
            stopOnFocus: true, // Prevents dismissing of toast on hover
        }).showToast();
    @endif
</script>
<style>
    .card {
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }

    .card-text {
        flex-grow: 1;
    }

    .fas {
        width: 20px;
        text-align: center;
        margin-right: 5px;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-outline-primary.ml-2 {
        margin-top: 0.5rem;
    }
</style>

<script src="{{ asset('bkk/dist/assets/vendors/toastify/toastify.js') }}"></script>
<script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>

<script>
    document.querySelectorAll('input[class="filepond"]').forEach(inputElement => {
        FilePond.create(inputElement);
    });

    FilePond.setOptions({
        server: {
            url: '/upload-file',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });
</script>

@endsection
