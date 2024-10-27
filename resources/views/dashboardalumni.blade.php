@extends('layout.main')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <div class="container mt-4">
        <h2>Informasi Lowongan Pekerjaan</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('job.search') }}" class="mb-5">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari lowongan..."
                    value="{{ request()->query('search') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <div class="row">
            @forelse($Loker as $item)
            <div class="col-md-6 mb-4">
                <div class="card hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{ asset('storage/images/' . $item->perusahaan->logo) }}" 
                                 alt="Logo Perusahaan" 
                                 class="me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            <div>
                                <h5 class="card-title mb-1">{{ $item->jabatan }}</h5>
                                <h6 class="card-subtitle text-muted">{{ $item->perusahaan->nama }}</h6>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <p class="card-text mb-2">
                                <i class="fas fa-clock"></i> {{ $item->jenis_waktu_pekerjaan }}<br>
                                <i class="fas fa-map-marker-alt"></i> {{ $item->perusahaan->alamat }}<br>
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($item->waktu)->format('j M Y H:i') }} sampai
                                {{ $item->tanggal_akhir }}
                            </p>
                            <p class="card-text">{{ $item->deskripsi }}</p>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('detailloker', $item->id_lowongan_pekerjaan) }}" 
                               class="btn btn-primary">
                                Lihat Detail
                            </a>
                            
                            @php
                                $hasApplied = \App\Models\Lamaran::where('id_lowongan_pekerjaan', $item->id_lowongan_pekerjaan)
                                    ->where('nik', $alumniLogin->nik)
                                    ->exists();
                            @endphp
                            
                            @if (!$hasApplied)
                                <button class="btn btn-outline-primary" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#lamarModal{{ $item->id_lowongan_pekerjaan }}">
                                    Lamar
                                </button>
                            @else
                                <button class="btn btn-secondary" disabled>
                                    Lamaran Sudah Dikirim
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

                <!-- Lamar Modal -->
                <div class="modal fade" id="lamarModal{{ $item->id_lowongan_pekerjaan }}" tabindex="-1"
                    aria-labelledby="lamarModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="lamarModalLabel">File Tambahan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Jika Anda tidak menambahkan file tambahan, maka kami akan mengambil informasi dari profil
                                    Anda.</p>
                                <div id="alert-container"></div>
                                <form action="{{ route('lamar.store') }}" method="POST" id="applicationForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id_lowongan_pekerjaan"
                                        value="{{ $item->id_lowongan_pekerjaan }}">

                                    <!-- FilePond file input -->
                                    <div class="form-group">
                                        <input type="file" name="file[]"
                                            id="file-{{ $item->id_lowongan_pekerjaan }}" class="filepond" multiple>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Apply</button>
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

    <script>
        // Inisialisasi FilePond untuk setiap elemen input file dengan kelas filepond
        document.querySelectorAll('input.filepond').forEach(inputElement => {
            FilePond.create(inputElement);
        });

        // Konfigurasi FilePond agar bisa mengunggah file ke server Laravel
        FilePond.setOptions({
            server: {
                process: {
                    url: '/upload-temp', // Endpoint untuk mengunggah file
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF untuk keamanan
                    },
                },
                revert: '/revert-file', // Endpoint untuk menghapus file jika perlu
            },
            allowMultiple: true, // Mengizinkan unggahan banyak file
            maxFiles: 5 // Batas maksimal file yang bisa diunggah
        });
    </script>

    <script src="{{ asset('bkk/dist/assets/vendors/toastify/toastify.js') }}"></script>
    <script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>
@endsection
