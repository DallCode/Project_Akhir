@extends('layout.main')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.css">

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


                        <button class="btn btn-outline-primary ml-2" data-bs-toggle="modal"
                            data-bs-target="#lamarModal{{ $item->id_lowongan_pekerjaan }}">Lamar</button>
                    </div>
                </div>
            </div>

            <!-- Lamar Modal -->
            <div class="modal fade" id="lamarModal{{ $item->id_lowongan_pekerjaan }}" tabindex="-1"
                aria-labelledby="lamarModalLabel" aria-hidden="true" data-bs-backdrop="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="lamarModalLabel">File Tambahan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Jika anda tidak menambahkan file tambahan maka kami akan mengambil informasi dari
                                profil anda</p>
                                <form id="importForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" id="file" class="filepond" />
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

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $Loker->links() }}
        </div>
    </div>
</div>

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
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>


<script>
    // Register FilePond instance
    const pond = FilePond.create(document.querySelector('input[id="file"]'), {
        server: {
            process: {
                url: '{{ route('upload.file') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                onload: (response) => {
                    // This function will be called when the file is successfully uploaded
                    return JSON.parse(response).fileName;
                },
                onerror: (response) => {
                    // This function will be called when there's an error during upload
                    const error = JSON.parse(response);
                    showAlert(error.error || 'An error occurred during file upload', 'danger');
                }
            },
            revert: null,
            restore: null,
            load: null,
            fetch: null,
        },
        allowMultiple: false,
        credits: false
    });

    // Handle form submission
    document.getElementById('importForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Get the file name from FilePond
        const files = pond.getFiles();
        if (files.length === 0) {
            showAlert('Please select a file to import.', 'danger');
            return;
        }
        const fileName = files[0].serverId;

        // Send import request
        fetch('{{ route('import') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ file: fileName })
        })
        .then(response => response.json())
        .then(data => {
            showAlert(data.alert, data.alert_type);
            if (data.alert_type === 'success') {
                pond.removeFile();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred during import. Please check the console for more details.', 'danger');
        });
    });

    function showAlert(message, type) {
        const alertContainer = document.getElementById('alert-container');
        alertContainer.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }
</script>
@endsection
